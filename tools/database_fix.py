import pymysql.cursors

connection = pymysql.connect(
    host="db",
    user="root",
    password="mariadb",
    database="order",
    cursorclass=pymysql.cursors.DictCursor
)

with connection:
    with connection.cursor() as cursor:
        #first name
        sql = "SELECT id, first_name FROM customer WHERE first_name LIKE '% ';"
        cursor.execute(sql)
        results = cursor.fetchall()
        print(results)
        for result in results:
            insertSql = "UPDATE `customer` SET first_name = %s WHERE `id` = %s; "
            newFirstName = result['first_name'].strip()
            newId = int(result['id'])
            values = (newFirstName, newId)
            cursor.execute(insertSql, values)
        #last name
        sql = "SELECT id, last_name FROM customer WHERE last_name LIKE '% ';"
        cursor.execute(sql)
        results = cursor.fetchall()
        print(results)
        for result in results:
            insertSql = "UPDATE `customer` SET last_name = %s WHERE `id` = %s; "
            newLastName = result['last_name'].strip()
            newId = int(result['id'])
            values = (newLastName, newId)
            cursor.execute(insertSql, values)
        #make
        sql = "SELECT id, make FROM automobile WHERE make LIKE '% ';"
        cursor.execute(sql)
        results = cursor.fetchall()
        print(results)
        for result in results:
            insertSql = "UPDATE `automobile` SET make = %s WHERE `id` = %s; "
            newMake = result['make'].strip()
            newId = int(result['id'])
            values = (newMake, newId)
            cursor.execute(insertSql, values)
        #model
        sql = "SELECT id, model FROM automobile WHERE model LIKE '% ';"
        cursor.execute(sql)
        results = cursor.fetchall()
        print(results)
        for result in results:
            insertSql = "UPDATE `automobile` SET model = %s WHERE `id` = %s; "
            newModel = result['model'].strip()
            newId = int(result['id'])
            values = (newModel, newId)
            cursor.execute(insertSql, values)
        connection.commit()
        #connection.close()