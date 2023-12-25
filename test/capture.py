# import cv2
# import pytesseract

# # Start the camera
# cap = cv2.VideoCapture(0)

# while True:
#     # Read the frame from the camera
#     ret, frame = cap.read()

#     # Display the frame
#     cv2.imshow('Video Feed', frame)

#     # Press 'c' to capture a frame and use Tesseract on the captured frame
#     key = cv2.waitKey(1)
#     if key == ord('c'):
#         # Convert the frame to grayscale
#         gray_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

#         # Apply thresholding
#         _, thresholded_frame = cv2.threshold(gray_frame, 128, 255, cv2.THRESH_BINARY)

#         # Use Tesseract to convert the thresholded image to text
#         text = pytesseract.image_to_string(thresholded_frame, config='--oem 3 --psm 6')

#         # Display the captured frame
#         cv2.imshow('Captured Frame', thresholded_frame)

#         # Print the extracted text
#         print("Extracted Text:", text)

#     # Press 'q' to exit the program
#     elif key == ord('q'):
#         break

# # Release the camera and close all windows
# cap.release()
# cv2.destroyAllWindows()






# --oem 0: Legacy OCR Engine.
# --oem 1: LSTM OCR Engine.
# --oem 2: Default OCR Engine (LSTM falling back to Legacy).
# --oem 3: Fully LSTM OCR Engine.






import cv2
import pytesseract

# Start the camera
cap = cv2.VideoCapture(0)

while True:
    # Read the frame from the camera
    ret, frame = cap.read()

    # Display the frame
    cv2.imshow('Video Feed', frame)

    # Press 'c' to capture a frame and use Tesseract on the captured frame
    key = cv2.waitKey(1)
    if key == ord('c'):
        # Convert the frame to grayscale
        gray_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

        # Apply adaptive thresholding
        thresholded_frame = cv2.adaptiveThreshold(
            gray_frame, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY, 11, 2
        )

        # Use Tesseract to convert the thresholded image to text
        text = pytesseract.image_to_string(thresholded_frame, config='--oem 3 --psm 6')

        # Display the captured frame
        cv2.imshow('Captured Frame', thresholded_frame)

        # Print the extracted text
        print("\n Extracted Text:", text)

    # Press 'q' to exit the program
    elif key == ord('q'):
        break

# Release the camera and close all windows
cap.release()
cv2.destroyAllWindows()
