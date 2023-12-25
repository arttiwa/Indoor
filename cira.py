
if countLP <= 0:
    print("No data to count")
    payload["Show"] = "No data to count"
else:
    sql = "SELECT * FROM `timetracking` WHERE  licenseplate_data =  %s AND  exit_time IS NULL "
    val = (nameLP,)
    mycursor.execute(sql, val)
    records = mycursor.fetchall()
    #print(records)  #[(5, datetime.datetime(2023, 12, 17, 14, 56, 35), None, '6กณ599', 3)]

    if mycursor.rowcount <= 0 and way == "exit":
        # check for entry
        print("!!!ALERT WHY THIS CAR IS EXIT WITH OUT ENTRY  BEFORE")
        Alert = "shit who is that"
        
       #sql = "INSERT INTO `timetracking` VALUES (NULL, NULL, %s, %s, 3, %s)"
        #val = (timeN, nameLP, nameBKK)
       # mycursor.execute(sql, val)
        #mysql.commit()
        
    elif mycursor.rowcount == 1 and way == "entry":
        # for entry
        print("!!!ALERT WHY THIS CAR IS ENTRY AGAIN BRO I THINK U DIDN'T EXIT")
        Alert = "shit how you go outside and i don't know'"
        
      #  sql = "INSERT INTO `timetracking` VALUES (NULL, %s, NULL, %s, 3, %s)"
       # val = (timeN, nameLP, nameBKK)
       # mycursor.execute(sql, val)
       # mysql.commit()

    elif mycursor.rowcount <= 0 and way == "entry":
        # for entry
        sql = "INSERT INTO `timetracking` VALUES (NULL, %s, NULL, %s, 3, %s)"
        val = (timeN, nameLP, nameBKK)
        mycursor.execute(sql, val)
        mysql.commit()
        
    elif mycursor.rowcount == 1 and way == "exit":
        # for exit
        sql = "UPDATE `timetracking` SET `exit_time` = %s WHERE `licenseplate_data` = %s"
        val = (timeN, nameLP)
        mycursor.execute(sql, val)
        mysql.commit()
        