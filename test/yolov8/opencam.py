import cv2
import time

# Open the default camera (index 0)
cap = cv2.VideoCapture(0)

# Initialize variables for FPS calculation
fps_start_time = time.time()
fps_frame_count = 0

while cap.isOpened():
    # Read a frame from the camera
    ret, frame = cap.read()

    if ret:
        # Display the frame in a window named 'Webcam Feed'
        cv2.imshow('Webcam Feed', frame)

        # Increment frame count for FPS calculation
        fps_frame_count += 1

        # Calculate FPS every second
        if time.time() - fps_start_time >= 1:
            fps = fps_frame_count / (time.time() - fps_start_time)
            print(f"FPS: {fps:.2f}")

            # Reset variables for the next FPS calculation
            fps_start_time = time.time()
            fps_frame_count = 0

        # Sleep for 1 second
        time.sleep(1)

        # Waiting for user input
        key = cv2.waitKey(1)

        # 'q' to exit
        if key == ord('q'):
            break

# Release the camera and close all windows
cap.release()
cv2.destroyAllWindows()
