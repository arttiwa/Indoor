import cv2
import numpy as np
import pytesseract

# Load YOLO
net = cv2.dnn.readNet("yolov3.weights", "yolov3.cfg")
layer_names = net.getUnconnectedOutLayersNames()

# Start the camera
cap = cv2.VideoCapture(0)

while True:
    # Read the frame from the camera
    ret, frame = cap.read()

    # Prepare the frame for YOLO
    blob = cv2.dnn.blobFromImage(frame, 1/255.0, (416, 416), swapRB=True, crop=False)
    net.setInput(blob)
    outs = net.forward(layer_names)

    # List to store text regions for Tesseract
    text_regions = []

    # Process YOLO outputs
    for out in outs:
        for detection in out:
            scores = detection[5:]
            class_id = np.argmax(scores)
            confidence = scores[class_id]
            if confidence > 0.5 and class_id == 0:  # Assuming class 0 is text
                center_x, center_y, width, height = (detection[0:4] * np.array([frame.shape[1], frame.shape[0], frame.shape[1], frame.shape[0]])).astype(int)
                x, y = int(center_x - width/2), int(center_y - height/2)

                # Crop the region where text is located
                cropped_text_region = frame[y:y+height, x:x+width]

                # Add the cropped text region to the list
                text_regions.append(cropped_text_region)

                # Display the captured frame with bounding box
                cv2.rectangle(frame, (x, y), (x+width, y+height), (0, 255, 0), 2)
                cv2.imshow('Text Detection', frame)

    # Perform OCR using Tesseract on each text region
    for idx, text_region in enumerate(text_regions):
        text = pytesseract.image_to_string(text_region, config='--oem 3 --psm 6')
        print(f"Text in region {idx + 1}: {text}")

    # Display the frame
    cv2.imshow('Video Feed', frame)

    # Press 'q' to exit the program
    key = cv2.waitKey(1)
    if key == ord('q'):
        break

# Release the camera and close all windows
cap.release()
cv2.destroyAllWindows()
