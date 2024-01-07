# import cv2
# import pytesseract

# # Load YOLO
# net = cv2.dnn.readNet("yolov3.weights", "yolov3.cfg")
# layer_names = net.getLayerNames()
# output_layers = [layer_names[i[0] - 1] for i in net.getUnconnectedOutLayers()]

# # Set the path to the Tesseract executable (update this with your Tesseract installation path)
# pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

# # Capture video or read an image
# cap = cv2.VideoCapture(0)  # You can replace 0 with the video file path

# while True:
#     # Read frame from the video
#     ret, frame = cap.read()

#     # YOLO object detection
#     height, width, channels = frame.shape
#     blob = cv2.dnn.blobFromImage(frame, 0.00392, (416, 416), (0, 0, 0), True, crop=False)
#     net.setInput(blob)
#     outs = net.forward(output_layers)

#     # Process YOLO outputs
#     class_ids = []
#     confidences = []
#     boxes = []

#     for out in outs:
#         for detection in out:
#             scores = detection[5:]
#             class_id = np.argmax(scores)
#             confidence = scores[class_id]
#             if confidence > 0.5:  # Adjust confidence threshold as needed
#                 # YOLO returns normalized coordinates; convert to pixel coordinates
#                 center_x = int(detection[0] * width)
#                 center_y = int(detection[1] * height)
#                 w = int(detection[2] * width)
#                 h = int(detection[3] * height)

#                 # Rectangle coordinates
#                 x = int(center_x - w / 2)
#                 y = int(center_y - h / 2)

#                 boxes.append([x, y, w, h])
#                 confidences.append(float(confidence))
#                 class_ids.append(class_id)

#     # Non-maximum suppression to remove redundant overlapping boxes
#     indexes = cv2.dnn.NMSBoxes(boxes, confidences, 0.5, 0.4)

#     # Text region filtering and OCR
#     for i in range(len(boxes)):
#         if i in indexes:
#             x, y, w, h = boxes[i]
#             roi = frame[y:y + h, x:x + w]

#             # Apply OCR on the text region
#             text = pytesseract.image_to_string(roi, config='--psm 6')  # Adjust OCR config as needed

#             # Draw bounding box and display text
#             cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)
#             cv2.putText(frame, text, (x, y - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 2)

#     # Display the result
#     cv2.imshow("Real-Time Text Detection", frame)

#     # Break the loop if 'q' key is pressed
#     if cv2.waitKey(1) & 0xFF == ord('q'):
#         break

# cap.release()
# cv2.destroyAllWindows()

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
