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

            System.out.println("Dropping tables...");
            stmt.executeUpdate("DROP TABLE IF EXISTS Recommend_Book;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Participate_in;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Question;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Quiz;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Participate;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Challenge;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Responds;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Reads_book;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Likes_comment;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Likes_quote;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Comment;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Friends;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Replies;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Likes_post;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Post;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Recommend_Booklist;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Follows;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Contains;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Librarian;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Booklist;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Edit_request;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Quote;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Series;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Edition;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Book;");
            stmt.executeUpdate("DROP TABLE IF EXISTS Author;");
            stmt.executeUpdate("DROP TABLE IF EXISTS User;");

            System.out.println("Creating table user...");
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
            System.out.println("User table is successfully created.\n");

            System.out.println("Creating table author...");
            String createAuthorSQL = "CREATE TABLE Author(" +
                    "author_id INT AUTO_INCREMENT, " +
                    "user_id INT NOT NULL, " +
                    "num_book INT NOT NULL DEFAULT 0, " +
                    "PRIMARY KEY( author_id ), " +
                    "FOREIGN KEY( user_id ) references User( user_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createAuthorSQL);
            System.out.println("Author table is successfully created.\n");

            System.out.println("Creating table book...");
            String createBookSQL = "create table Book(" +
                    "book_id int AUTO_INCREMENT," +
                    "book_name varchar(75) NOT NULL," +
                    "author varchar(50) NOT NULL," +
                    "genre varchar(40) NOT NULL," +
                    "year int NOT NULL," +
                    "description varchar(600) NOT NULL," +
                    "author_id int NOT NULL," +
                    "primary key( book_id )," +
                    "foreign key( author_id ) references Author(author_id))" +
                    "engine=innodb;";
            stmt.executeUpdate(createBookSQL);
            System.out.println("Book table is successfully created.\n");

            System.out.println("Creating table edition...");
            String createEditionSQL = "create table Edition(" +
                    "edition_no int AUTO_INCREMENT," +
                    "book_id int NOT NULL," +
                    "page_count int NOT NULL," +
                    "publisher varchar(40) NOT NULL," +
                    "language varchar(15) NOT NULL," +
                    "format varchar(30) NOT NULL," +
                    "cover_photo varbinary(50) NOT NULL," +
                    "translator varchar(30)," +
                    "primary key( edition_no, book_id )," +
                    "foreign key( book_id ) references Book(book_id))" +
                    "engine=innodb;";
            stmt.executeUpdate(createEditionSQL);
            System.out.println("Edition table is successfully created.\n");

            System.out.println("Creating table series...");
            String createSeriesSQL = "create table Series(" +
                    "sequel_id int NOT NULL," +
                    "original_id int NOT NULL," +
                    "series_name varchar(30) NOT NULL," +
                    "primary key( sequel_id, original_id )," +
                    "foreign key( original_id ) references Book(book_id)," +
                    "foreign key( sequel_id ) references Book(book_id))" +
                    "engine=innodb;";
            stmt.executeUpdate(createSeriesSQL);
            System.out.println("Series table is successfully created.\n");

            System.out.println("Creating table quote...");
            String createQuoteSQL = "create table Quote(" +
                    "quote_id int AUTO_INCREMENT," +
                    "text varchar(300) NOT NULL," +
                    "tag varchar(50) NOT NULL," +
                    "book_id int NOT NULL," +
                    "user_id int NOT NULL," +
                    "primary key( quote_id )," +
                    "foreign key( book_id ) references Book(book_id)," +
                    "foreign key( user_id ) references User(user_id))" +
                    "engine=innodb;";
            stmt.executeUpdate(createQuoteSQL);
            System.out.println("Quote table is successfully created.");

            System.out.println("Creating table edit_request...");
            String createEditRequestSQL = "create table Edit_Request(" +
                    "edit_id int AUTO_INCREMENT," +
                    "new_book_name varchar(75)," +
                    "new_book_author varchar(50)," +
                    "new_book_genre varchar(40)," +
                    "new_book_year int," +
                    "new_book_edition_no int NOT NULL," +
                    "new_book_page_count int," +
                    "new_book_publisher varchar(40)," +
                    "new_book_language varchar(40)," +
                    "new_book_format varchar(30)," +
                    "new_book_cover_photo varbinary(40)," +
                    "new_book_translator varchar(30)," +
                    "additional_notes varchar(300)," +
                    "user_id int NOT NULL," +
                    "book_id int NOT NULL," +
                    "date date NOT NULL," +
                    "primary key( edit_id )," +
                    "foreign key( new_book_edition_no, book_id ) references Edition(edition_no, book_id)," +
                    "foreign key( book_id ) references Book(book_id)," +
                    "foreign key( user_id ) references User(user_id))" +
                    "engine=innodb;";
            stmt.executeUpdate(createEditRequestSQL);
            System.out.println("Edit Request table is successfully created.\n");

            System.out.println("Creating table booklist...");
            String createBookListSQL = "create table Booklist(" +
                    "list_id int AUTO_INCREMENT," +
                    "list_name varchar(30) DEFAULT \"Madness\"," +
                    "description varchar(300) DEFAULT \"Description\"," +
                    "user_id int NOT NULL," +
                    "primary key( list_id )," +
                    "foreign key( user_id ) references User(user_id))" +
                    "engine=innodb;";
            stmt.executeUpdate(createBookListSQL);
            System.out.println("BookList table is successfully created.\n");

            System.out.println("Creating table librarian...");
            String createLibrarianSQL = "create table Librarian(" +
                    "librarian_id int AUTO_INCREMENT, " +
                    "user_id int, " +
                    "primary key( librarian_id ), " +
                    "foreign key( user_id ) references User (user_id))" +
                    "engine=innodb;";
            stmt.executeUpdate(createLibrarianSQL);
            System.out.println("Librarian table is successfully created.\n");

            System.out.println("Creating table Contains...");
            String createContainsSQL = "create table Contains (" +
                    "list_id int NOT NULL," +
                    "book_id int NOT NULL," +
                    "primary key( list_id, book_id )," +
                    "foreign key( list_id ) references Booklist(list_id)," +
                    "foreign key( book_id ) references Book(book_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createContainsSQL);
            System.out.println("Contains table is successfully created.\n");

            System.out.println("Creating table Follows...");
            String createFollowsSQL = "create table Follows (" +
                    "list_id int NOT NULL," +
                    "user_id int NOT NULL," +
                    "primary key( list_id, user_id)," +
                    "foreign key( list_id ) references Booklist(list_id)," +
                    "foreign key( user_id) references User(user_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createFollowsSQL);
            System.out.println("Follows table is successfully created.\n");

            System.out.println("Creating table Recommend_Booklist...");
            String createRecommendBooklistSQL = "create table Recommend_Booklist (" +
                    "list_id int NOT NULL," +
                    "recommended_id int NOT NULL," +
                    "recommender_id int NOT NULL," +
                    "primary key( list_id, recommended_id, recommender_id )," +
                    "foreign key( list_id ) references Booklist(list_id)," +
                    "foreign key( recommended_id ) references User(user_id)," +
                    "foreign key( recommender_id ) references User(user_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createRecommendBooklistSQL);
            System.out.println("Recommend_Booklist table is successfully created.\n");

            System.out.println("Creating table Post...");
            String createPostSQL = "create table Post (" +
                    "post_id int AUTO_INCREMENT," +
                    "book_id int NOT NULL," +
                    "date date NOT NULL," +
                    "content varchar(300) NOT NULL," +
                    "rate int NOT NULL," +
                    "user_id int NOT NULL," +
                    "like_count int NOT NULL," +
                    "comment_count int NOT NULL," +
                    "primary key( post_id )," +
                    "foreign key( user_id ) references User(user_id)," +
                    "foreign key( book_id ) references Book(book_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createPostSQL);
            System.out.println("Post table is successfully created.\n");

            System.out.println("Creating table Likes_post...");
            String createLikesPostSQL = "create table Likes_post(" +
                    "user_id int NOT NULL," +
                    "post_id int NOT NULL," +
                    "primary key( user_id, post_id )," +
                    "foreign key( user_id ) references User(user_id)," +
                    "foreign key( post_id ) references Post(post_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createLikesPostSQL);
            System.out.println("Likes_post table is successfully created.\n");

            System.out.println("Creating table Replies...");
            String createRepliesSQL = "create table Replies(" +
                    "post_id int NOT NULL," +
                    "author_id int NOT NULL," +
                    "reply varchar(300) NOT NULL," +
                    "primary key( post_id )," +
                    "foreign key( post_id) references Post(post_id)," +
                    "foreign key( author_id) references Author(author_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createRepliesSQL);
            System.out.println("Replies table is successfully created.\n");

            System.out.println("Creating table Friends...");
            String createFriendsSQL = "create table Friends(" +
                    "user_id int NOT NULL," +
                    "friend_id int NOT NULL," +
                    "primary key( user_id, friend_id )," +
                    "foreign key( user_id ) references User(user_id)," +
                    "foreign key( friend_id) references User(user_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createFriendsSQL);
            System.out.println("Friends table is successfully created.");

            System.out.println("Creating table Comment...");
            String createCommentSQL = "create table Comment (" +
                    "comment_id int AUTO_INCREMENT," +
                    "date date NOT NULL," +
                    "content varchar(300) NOT NULL," +
                    "user_id int NOT NULL," +
                    "post_id int NOT NULL," +
                    "primary key ( comment_id )," +
                    "foreign key ( user_id ) references User(user_id)," +
                    "foreign key ( post_id ) references Post(post_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createCommentSQL);
            System.out.println("Comment table is successfully created.\n");

            System.out.println("Creating table Likes_quote...");
            String createLikesQuoteSQL = "create table Likes_quote(" +
                    "user_id int NOT NULL," +
                    "quote_id int NOT NULL," +
                    "primary key( user_id, quote_id )," +
                    "foreign key( user_id ) references User(user_id)," +
                    "foreign key( quote_id ) references Quote(quote_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createLikesQuoteSQL);
            System.out.println("Likes_quote table is successfully created.\n");

            System.out.println("Creating table Likes_comment...");
            String createLikesCommentSQL = "create table Likes_comment(" +
                    "user_id int NOT NULL," +
                    "comment_id int NOT NULL," +
                    "primary key( user_id, comment_id )," +
                    "foreign key( user_id ) references User(user_id)," +
                    "foreign key( comment_id ) references Comment(comment_id))" +
                    "ENGINE=innodb;";

            stmt.executeUpdate(createLikesCommentSQL);
            System.out.println("Likes_comment table is successfully created.\n");

            System.out.println("Creating table Reads...");
            String createReadsSQL = "create table Reads_book(" +
                    "book_id int NOT NULL," +
                    "edition_no int NOT NULL," +
                    "user_id int NOT NULL," +
                    "progress int NOT NULL," +
                    "date timestamp NOT NULL," +
                    "primary key( book_id, user_id, edition_no, date)," +
                    "foreign key(edition_no, book_id) references Edition(edition_no, book_id)," +
                    "foreign key( user_id ) references User(user_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createReadsSQL);
            System.out.println("Reads table is successfully created.\n");

            System.out.println("Creating table Responds...");
            String createRespondsSQL = "create table Responds(" +
                    "edit_id int NOT NULL," +
                    "librarian_id int NOT NULL," +
                    "response char(1) NOT NULL," +
                    "primary key( edit_id )," +
                    "foreign key( edit_id ) references User(user_id)," +
                    "foreign key( librarian_id ) references Librarian(librarian_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createRespondsSQL);
            System.out.println("Responds table is successfully created.");

            System.out.println("Creating table Challenge...");
            String createChallengeSQL = "create table Challenge(" +
                    "challenge_id int AUTO_INCREMENT," +
                    "challenge_name varchar(40) NOT NULL," +
                    "start_date date NOT NULL," +
                    "end_date date NOT NULL," +
                    "goal int NOT NULL," +
                    "librarian_id int NOT NULL," +
                    "primary key( challenge_id )," +
                    "foreign key( librarian_id ) references Librarian (librarian_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createChallengeSQL);
            System.out.println("Challenge table is successfully created.");

            System.out.println("Creating table Participate...");
            String createParticipateSQL = "create table Participate(" +
                    "list_id int NOT NULL," +
                    "challenge_id int NOT NULL," +
                    "user_id int NOT NULL," +
                    "challlenge_progress int NOT NULL," +
                    "primary key( list_id, challenge_id, user_id )," +
                    "foreign key( list_id ) references Booklist (list_id)," +
                    "foreign key( challenge_id) references Challenge (challenge_id)," +
                    "foreign key( user_id ) references User (user_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createParticipateSQL);
            System.out.println("Participate table is successfully created.");

            System.out.println("Creating table Quiz...");
            String createQuizSQL = "create table Quiz(" +
                    "quiz_id int AUTO_INCREMENT," +
                    "quiz_name varchar(300) NOT NULL," +
                    "librarian_id int NOT NULL," +
                    "start_date date NOT NULL," +
                    "end_date date NOT NULL," +
                    "primary key( quiz_id )," +
                    "foreign key( librarian_id ) references Librarian (librarian_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createQuizSQL);
            System.out.println("Quiz table is successfully created.\n");

            System.out.println("Creating table Question...");
            String createQuestionSQL = "create table Question(" +
                    "question_id int AUTO_INCREMENT," +
                    "quiz_id int NOT NULL," +
                    "librarian_id int NOT NULL," +
                    "question_text varchar(300) NOT NULL," +
                    "answer char(1) NOT NULL," +
                    "option_a varchar(200) NOT NULL," +
                    "option_b varchar(200) NOT NULL," +
                    "option_c varchar(200) NOT NULL," +
                    "option_d varchar(200) NOT NULL," +
                    "points int NOT NULL," +
                    "primary key( question_id)," +
                    "foreign key( quiz_id ) references Quiz (quiz_id)," +
                    "foreign key( librarian_id ) references Librarian (librarian_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createQuestionSQL);
            System.out.println("Question table is successfully created.\n");

            System.out.println("Creating table Participate_in...");
            String createParticipateInSQL = "create table Participate_in(" +
                    "quiz_id int NOT NULL," +
                    "user_id int NOT NULL," +
                    "question_id int NOT NULL," +
                    "user_answer char(1)," +
                    "primary key( quiz_id, user_id, question_id)," +
                    "foreign key( quiz_id) references Quiz( quiz_id)," +
                    "foreign key( user_id) references User( user_id)," +
                    "foreign key( question_id) references Question( question_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createParticipateInSQL);
            System.out.println("Participate_in table is successfully created.");

            System.out.println("Creating table Recommend_Book...");
            String createRecommendBookSQL = "create table Recommend_Book (" +
                    "book_id int NOT NULL," +
                    "recommended_id int NOT NULL," +
                    "recommender_id int NOT NULL," +
                    "primary key( book_id, recommended_id, recommender_id )," +
                    "foreign key( book_id ) references Book(book_id)," +
                    "foreign key( recommended_id ) references User(user_id)," +
                    "foreign key( recommender_id ) references User(user_id))" +
                    "ENGINE=innodb;";
            stmt.executeUpdate(createRecommendBookSQL);
            System.out.println("Recommend_Book table is successfully created.");
        }
        catch (SQLException e) {
            System.out.println("SQLException: " + e.getMessage());
            e.printStackTrace();
        }

    }
}
