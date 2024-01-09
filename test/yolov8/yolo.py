import cv2
from ultralytics import YOLO
import time
import os

# Initialize YOLOv8 model
model = YOLO('sign_model.pt')

# Open cam
cap = cv2.VideoCapture(0)

# Set the desired frame rate
target_fps = 2
delay = 1 / target_fps

# Set the new width and height for the resized frames
new_width = 640  # Adjust as needed
new_height = 480  # Adjust as needed

# Create the directory to save captured images
capture_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\cap'
os.makedirs(capture_directory, exist_ok=True)

# Create the directory to save cropped images
output_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\sign'
os.makedirs(output_directory, exist_ok=True)

while cap.isOpened():
    success, frame = cap.read()

    if success:
        # Resize the frame before passing it to the model
        resized_frame = cv2.resize(frame, (new_width, new_height))

        try:
            start = time.perf_counter()

            # Run YOLO inference on the resized frame
            result = model(resized_frame)

            end = time.perf_counter()
            total_time = end - start
            fps = 1 / total_time

            # Annotate the resized frame with YOLO results
            annotated_frame = result[0].plot()

            # Display the annotated frame
            cv2.putText(annotated_frame, f"FPS: {int(fps)}", (10, 30), cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2, cv2.LINE_AA)
            cv2.imshow('YOLO Result', annotated_frame)

            # Check if there are any detections
            if result and result[0].names:
                # Print detected class names
                print("Detected class names:", result[0].names)

                # Check if the 'sign' is detected
                if 'sign' in result[0].names:
                    print("Sign detected!")

            # Waiting for user input
            key = cv2.waitKey(1)

            # 'q' to exit
            if key == ord('q'):
                break

            # 'c' to capture
            elif key == ord('c'):
                # Save the captured image to the capture directory
                capture_filename = os.path.join(capture_directory, f"captured_{time.time()}.jpg")
                cv2.imwrite(capture_filename, frame)
                print(f"Image captured and saved as {capture_filename}")

        except AttributeError:
            # Handle the case when there are no detections (AttributeError)
            print("No detections found.")
            
# Release the camera and close all windows (in case it's not already done)
cap.release()
cv2.destroyAllWindows()
