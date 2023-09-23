import cv2
#import pytesseract

# เริ่มกล้อง
cap = cv2.VideoCapture(0)

# ตั้งค่าภาษาให้ Tesseract ตรวจจับ
#custom_config = r'--oem 3 --psm 6 -l eng'

while True:
    # อ่านภาพจากกล้อง
    ret, frame = cap.read()

    # แปลงภาพเป็นข้อความด้วย Tesseract
    #custom_config = r'--oem 3 --psm 6 --lang eng --whitelist ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
    #text = pytesseract.image_to_string(frame, config=custom_config)


    # แสดงผลลัพธ์บนหน้าจอ
    #cv2.imshow('Text Detection', frame)
    #print(text)
    cv2.imshow('Camera', frame)
   

    # กด 'q' เพื่อออกจากโปรแกรม
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# ปิดกล้องและหน้าจอ
cap.release()
cv2.destroyAllWindows()
