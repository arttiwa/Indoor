#this code from Arttiwa
import cv2
from ultralytics import YOLO
import time
import os
import subprocess

# Initialize YOLOv8 model
model = YOLO('sign_model.pt')

# Open cam
cap = cv2.VideoCapture(0)

# Set the desired frame rate
target_fps = 2
delay = 1 / target_fps

# Set the new width and height for the resized frames
new_width = 640 
new_height = 480  

# Create the directory to save captured images
cap_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\new_data\cap'
os.makedirs(cap_directory, exist_ok=True)

# Create the directory to save cropped images
output_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\new_data\crop'
os.makedirs(output_directory, exist_ok=True)

#counter
count_pic = 0

while cap.isOpened():
    success, frame = cap.read()

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
            if result[0].names[0] == 'sign':
                if result[0].boxes is not None and len(result[0].boxes) > 0:
                    x, y, x2, y2 = result[0].boxes.xyxy[0].cpu().numpy().astype(int).tolist()
                    w, h = x2 - x, y2 - y
                    # Crop the region containing the target
                    cropped_image = frame[y:y + h, x:x + w]
                    
                    # # Save the cropped image to the output directory
                    # crop_image_filename = os.path.join(output_directory, f"cropped_{time.time()}.jpg")
                    # cv2.imwrite(crop_image_filename, cropped_image)
                    # print(f"Target detected! Cropped image saved as {crop_image_filename}")
                    
                    # # Save the annotated frame to the output directory
                    # cap_image_filename = os.path.join(cap_directory, f"captured_{time.time()}.jpg")
                    # cv2.imwrite(cap_image_filename, annotated_frame)
                    # print(f"Annotated frame saved as {cap_image_filename}")
                    
                    # Debugging: Print coordinates
                    print(f"Bounding box coordinates: x={x}, y={y}, w={w}, h={h}")
                    
                    count_pic += 1
                    print(count_pic)
                    
                    
                else:
                    print("No bounding box coordinates available.")
            else:
                print("No 'sign' detected.")
        else:
            print("No detections in the frame.")

         # Sleep to control the processing rate
        
        time.sleep(delay)
        
        # Waiting for user input
        key = cv2.waitKey(1)

        # 'q' to exit
        if key == ord('q'):
            break

        # picture = 3 then exit
        if count_pic == 3:
            break
        
    except Exception as e:
        # Handle exceptions
        print(f"Error: {e}")

# Release the camera and close all windows (in case it's not already done)
cap.release()
cv2.destroyAllWindows()

# Run next Python script
next_script_path = r'D:\xampp\htdocs\Indoor\test\yolov8\ocr_cal.py'
subprocess.run(['python', next_script_path])