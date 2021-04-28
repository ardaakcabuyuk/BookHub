import java.sql.*;
import java.sql.Connection;

public class DBConnector {
    public static void main(String[] args) {
        Connection connection = null;

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
        }
        catch(ClassNotFoundException e) {
            System.out.println("MySQL JDBC Driver not found!");
            e.printStackTrace();
        }

        final String USERNAME = "root";
        final String PASSWORD = "";
        final String DBNAME = "book_hub";
        final String URL = "jdbc:mysql://localhost/" + DBNAME;


        try{
            connection = DriverManager.getConnection(URL,USERNAME,PASSWORD);
        }
        catch(SQLException e) {
            System.out.println("Connection failed!");
            e.printStackTrace();
        }

        if(connection != null) {
            System.out.println("Connection established successfully");
        }
        else {
            System.out.println("Connection failed to established!");
        }

        Statement stmt;
        try {
            stmt = connection.createStatement();

            System.out.println("Dropping tables user.");
            stmt.executeUpdate("DROP TABLE IF EXISTS User;");

            System.out.println("Creating table student...");
            String createUserSQL = "CREATE TABLE User(" +
                    "user_id INT AUTO_INCREMENT, "+
                    "username VARCHAR(20) NOT NULL, " +
                    "name VARCHAR(20) NOT NULL, " +
                    "surname VARCHAR(20) NOT NULL, " +
                    "email VARCHAR(30) NOT NULL, " +
                    "password VARCHAR(30) NOT NULL, " +
                    "PRIMARY KEY( user_id ), " +
                    "UNIQUE(username)) " +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createUserSQL);
            System.out.println("User table is successfully created.");
            String insertUser = "INSERT INTO User (username, email, password, name, surname) Values (\"annen\", \"patates\", \"baban\", \"Ayse\", \"ali\")";
            stmt.executeUpdate(insertUser);
            /*
            System.out.println("Creating table student...");
            String createStudentSQL = "CREATE TABLE student(" +
                    "sid CHAR(12), " +
                    "sname VARCHAR(50), " +
                    "bdate DATE, " +
                    "address VARCHAR(50), " +
                    "scity VARCHAR(20), " +
                    "year CHAR(20), " +
                    "gpa FLOAT, " +
                    "nationality VARCHAR(20), " +
                    "PRIMARY KEY(sid)) " +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createStudentSQL);
            System.out.println("Student table is successfully created.");

            System.out.println("Creating company table...");
            String createCompanySQL = "CREATE TABLE company(" +
                    "cid CHAR(8), " +
                    "cname VARCHAR(20), " +
                    "quota INT, " +
                    "PRIMARY KEY(cid)) " +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createCompanySQL);
            System.out.println("Company table is successfully created.");

            System.out.println("Creating apply table...");
            String createApplySQL = "CREATE TABLE apply(" +
                    "sid CHAR(12), " +
                    "cid CHAR(8), " +
                    "PRIMARY KEY (sid,cid), " +
                    "FOREIGN KEY (sid) REFERENCES student(sid), " +
                    "FOREIGN KEY (cid) REFERENCES company(cid)) " +
                    "ENGINE=innodb";
            stmt.executeUpdate(createApplySQL);
            System.out.println("Apply table is successfully created.");

            System.out.println("Inserting values into student table...");
            String insertStudentSQL = "INSERT INTO student VALUES" +
                    "('21000001', 'John', '1999-05-14', 'Windy', 'Chicago', 'senior', 2.33, 'US'), " +
                    "('21000002', 'Ali', '2001-09-30', 'Nisantasi', 'Istanbul', 'junior', 3.26, 'TC'), " +
                    "('21000003', 'Veli', '2003-02-25', 'Nisantasi', 'Istanbul', 'freshman', 2.41, 'TC'), " +
                    "('21000004', 'Ayse', '2003-01-15', 'Tunali', 'Ankara', 'freshman', 2.55, 'TC');";
            stmt.executeUpdate(insertStudentSQL);
            System.out.println("Values have been inserted into student table.");

            System.out.println("Inserting values into company table...");
            String insertCompanySQL = "INSERT INTO company VALUES" +
                    "('C101', 'microsoft', 2), " +
                    "('C102', 'merkez bankasi', 5), " +
                    "('C103', 'tai', 3), " +
                    "('C104', 'tubitak', 5), " +
                    "('C105', 'aselsan', 3), " +
                    "('C106', 'havelsan', 4), " +
                    "('C107', 'milsoft', 2);";
            stmt.executeUpdate(insertCompanySQL);
            System.out.println("Values have been inserted into company table.");

            System.out.println("Inserting values into apply table...");
            String insertApplySQL = "INSERT INTO apply VALUES" +
                    "('21000001', 'C101'), " +
                    "('21000001', 'C102'), " +
                    "('21000001', 'C103'), " +
                    "('21000002', 'C101'), " +
                    "('21000002', 'C105'), " +
                    "('21000003', 'C104'), " +
                    "('21000003', 'C105'), " +
                    "('21000004', 'C107');";
            stmt.executeUpdate(insertApplySQL);
            System.out.println("Values have been inserted into apply table.");

            System.out.println("Printing student table: ");

            ResultSet students = stmt.executeQuery("SELECT * FROM student");

            while(students.next()) {
                System.out.printf("%12s | %12s | %12s | %12s | %12s | %12s | %12s | %12s%n",
                        students.getString("sid"),
                        students.getString("sname"),
                        students.getString("bdate"),
                        students.getString("address"),
                        students.getString("scity"),
                        students.getString("year"),
                        students.getString("gpa"),
                        students.getString("nationality"));
            }

            System.out.println("Program completed!");
        */
        }
        catch (SQLException e) {
            System.out.println("SQLException: " + e.getMessage());
            e.printStackTrace();
        }

    }
}
