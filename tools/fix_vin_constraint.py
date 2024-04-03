import pymysql.cursors

connection = pymysql.connect(
    host="localhost",
    user="dev",
    password="test_password",
    database="order",
    cursorclass=pymysql.cursors.DictCursor
)

with connection:
    with connection.cursor() as cursor:
        #find lengths of vin numbers and ids of automobiles
        sql = "SELECT id, LENGTH(vin), vin FROM automobile;"
        cursor.execute(sql)
        results = cursor.fetchall()
        # print(results)
        # get results with a length less that 17
        lessThan17 = []
        insertSql = "UPDATE `automobile` SET vin = %s WHERE `id` = %s; "
        for result in results:
            if result['LENGTH(vin)'] < 17:
                # add _ to vin to have length be 17
                lessThan17.append(result)
                newVin = result['vin'] + '_' * (17 - result['LENGTH(vin)'])
                newId = int(result['id'])
                values = (newVin, newId)
                cursor.execute(insertSql, values)
        connection.commit()
        print(len(lessThan17))