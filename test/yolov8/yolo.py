import cv2
from ultralytics import YOLO
import time

# Initialize YOLOv8 model
model = YOLO('sign_model.pt')

# Open cam
cap = cv2.VideoCapture(0)

while cap.isOpened():
    success, frame = cap.read()
    
    if success:
        start = time.perf_counter()
        # run yolo inference on the frame
        result = model(frame)
        
        end = time.perf_counter()
        total_time = end - start
        fps = 1 / total_time

        # Annotate the frame with YOLO results
        annotated_frame = result[0].plot()

        # Display the annotated frame
        cv2.putText(annotated_frame, f"FPS: {int(fps)}", (10, 30), cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2, cv2.LINE_AA)
        cv2.imshow('YOLO Result', annotated_frame)

    # Waiting for user input
    key = cv2.waitKey(1)

    # 'q' to exit
    if key == ord('q'):
        break

    # 'c' to capture
    elif key == ord('c'):
        # Your capture logic goes here
        print("Capture logic goes here")

# Release the camera and close all windows
cap.release()
cv2.destroyAllWindows()
