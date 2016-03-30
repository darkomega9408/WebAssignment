package vn.khmt.db;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;
import java.util.Properties;
import vn.khmt.hello.restful.Book;
import vn.khmt.hello.restful.Member;
import vn.khmt.hello.restful.User;

/**
 *
 * @author TheNhan
 */
public class ConnectToSQL {

    public static final String SQLSERVER = "sqlserver";
    public static final String SQLSERVERDRIVER = "com.microsoft.sqlserver.jdbc.SQLServerDriver";
    public static final String MYSQL = "mysql";
    public static final String MYSQLDRIVER = "com.mysql.jdbc.Driver";
    public static final String POSTGRESQL = "postgresql";
    public static final String POSTGRESQLDRIVER = "org.postgresql.Driver";

    Connection dbConnection = null;

    public ConnectToSQL(String type, String host, String dbname, String user, String pwd) {
        this.dbConnection = getDBConnection(type, host, dbname, user, pwd);
    }

    private Connection getDBConnection(String type, String host, String dbname, String user, String pwd) {
        if (type != null && !type.isEmpty()) {
            try {
                if (type.equalsIgnoreCase(SQLSERVER)) {
                    Class.forName(SQLSERVERDRIVER);
                    dbConnection = DriverManager.getConnection("jdbc:sqlserver://" + host + ":1433;database=" + dbname + ";sendStringParametersAsUnicode=true;useUnicode=true;characterEncoding=UTF-8;", user, pwd);
                } else if (type.equalsIgnoreCase(MYSQL)) {
                    Class.forName(MYSQLDRIVER);
                    dbConnection = DriverManager.getConnection("jdbc:mysql://" + host + ":3306/" + dbname, user, pwd);
                } else if (type.equalsIgnoreCase(POSTGRESQL)) {
                    Class.forName(POSTGRESQLDRIVER);
                    Properties props = new Properties();
                    props.put("user", user);
                    props.put("password", pwd);
                    props.put("sslmode", "require");
                    dbConnection = DriverManager.getConnection("jdbc:postgresql://" + host + ":5432/" + dbname + "?sslmode=require&user=" + user + "&password=" + pwd);
                }
                return dbConnection;
            } catch (ClassNotFoundException | SQLException ex) {
                System.err.println(ex.getMessage());
            }
        }
        return dbConnection;
    }

    
    /**************************
     * 
     * MEMBER
     * 
     **************************/
    
    public List<Member> getMembers(int userID) {
        try {
            String SQL = "SELECT * FROM member WHERE UserID = " + userID;
            Statement stmt = this.dbConnection.createStatement();
            ResultSet rs = stmt.executeQuery(SQL);
            List<Member> memberList = new ArrayList<Member>();
            while (rs.next())             
                memberList.add(getMember(rs));
            
            return memberList;
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }

    public Member addMember(Member newMember) {
        try {
            String SQL;
            if (newMember.getFather() == 0) {
                System.out.println("No father");
                SQL = "INSERT INTO member (UserID, MemberID, Name, BirthDate, Address, BirthPlace, Gender, Father, Avatar, Alive) VALUES (" + newMember.getUserID() + ", NULL, '" + newMember.getName() + "', '" + (new SimpleDateFormat("yyyy-MM-dd")).format(newMember.getBirthDate()) + "', '" + newMember.getAddress() + "', '" + newMember.getBirthPlace() + "', '" + newMember.getGender() + "', NULL, '" + newMember.getAvatar() + "', " + newMember.isAlive() + ")";
            } else {
                System.out.println("Has father");
                SQL = "INSERT INTO member (UserID, MemberID, Name, BirthDate, Address, BirthPlace, Gender, Father, Avatar, Alive) VALUES (" + newMember.getUserID() + ", NULL, '" + newMember.getName() + "', '" + (new SimpleDateFormat("yyyy-MM-dd")).format(newMember.getBirthDate()) + "', '" + newMember.getAddress() + "', '" + newMember.getBirthPlace() + "', '" + newMember.getGender() + "'," + newMember.getFather() + ", '" + newMember.getAvatar() + "', " + newMember.isAlive() + ")";
                System.out.println(SQL);
            }
            Statement stmt = this.dbConnection.createStatement();
            int resultInsert = stmt.executeUpdate(SQL);

            SQL = "SELECT * FROM member ORDER BY MemberID DESC LIMIT 1";
            ResultSet rs = stmt.executeQuery(SQL);

            if (rs.next()) 
               return getMember(rs);
            
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }

    public Member updateMember(Member newMemberInfo) {
        try {
            String SQL = "UPDATE member SET Name='" + newMemberInfo.getName() + "',BirthDate='" + (new SimpleDateFormat("yyyy-MM-dd")).format(newMemberInfo.getBirthDate()) + "',Address='" + newMemberInfo.getAddress() + "',BirthPlace='" + newMemberInfo.getBirthPlace() + "',Gender='" + newMemberInfo.getGender() + /*",Father=". $data['dsa'] .",Level=". $data['dsa'] .*/ "',Avatar='" + newMemberInfo.getAvatar() + "' WHERE userID=" + newMemberInfo.getUserID() + " AND MemberID=" + newMemberInfo.getMemberID();

            Statement stmt = this.dbConnection.createStatement();
            int resultInsert = stmt.executeUpdate(SQL);

            SQL = "SELECT * FROM member WHERE MemberID= " + newMemberInfo.getMemberID() + " AND UserID = " + newMemberInfo.getUserID();
            ResultSet rs = stmt.executeQuery(SQL);

            if (rs.next()) return getMember(rs);
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }

    public Member changeMemberAvatar(int userID, int memberID, String avatarLink) {
        try {
            String SQL = "UPDATE member SET Avatar='" + avatarLink + "' WHERE userID=" + userID + " AND MemberID=" + memberID;
            Statement stmt = this.dbConnection.createStatement();
            int resultUpdate = stmt.executeUpdate(SQL);

            SQL = "SELECT * FROM member WHERE MemberID= " + memberID + " AND UserID = " + userID;
            ResultSet rs = stmt.executeQuery(SQL);

            if (rs.next()) return getMember(rs);
            
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }

    public String deleteMember(int userID, int memberID) {
        try {
            String SQL = "DELETE FROM member WHERE UserID= " + userID + " AND MemberID=" + memberID;

            Statement stmt = this.dbConnection.createStatement();
            int resultDelete = stmt.executeUpdate(SQL);
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }

    private Member getMember(ResultSet rs) throws SQLException{      
                Member mem = new Member();
                mem.setUserID(rs.getInt("userID"));
                mem.setMemberID(rs.getInt("MemberID"));
                mem.setName(rs.getString("Name"));
                mem.setBirthDate(rs.getDate("BirthDate"));
                mem.setAddress(rs.getString("Address"));
                mem.setBirthPlace(rs.getString("BirthPlace"));
                mem.setGender(rs.getString("Gender"));
                mem.setFather(rs.getInt("Father"));
                mem.setAvatar(rs.getString("Avatar"));
                mem.setAlive(rs.getBoolean("Alive"));
                return mem;          
    }
    
    /**************************
     * 
     * USER
     * 
     **************************/
    private User getUser(ResultSet rs) throws SQLException{
        User user = new User();
                user.setId(rs.getInt("ID"));
                user.setUsername(rs.getString("Username"));
                user.setEmail(rs.getString("Email"));
                user.setPassword(rs.getString("Password"));
                user.setName(rs.getString("Name"));
                user.setRole(rs.getString("Role"));
                return user;
    }
            
    
    public User checkUser(String username, String password) {
        try {
            String SQL = "SELECT * FROM person WHERE username='" + username + "' AND password='" + password + "'";
            Statement stmt = this.dbConnection.createStatement();
            ResultSet rs = stmt.executeQuery(SQL);

            if (rs.next()) 
                return getUser(rs);
            
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }
    
    public List<User> getUsers() {
        try {
            String SQL = "SELECT ID, Username, Email, Name FROM person WHERE Role = 'user'";
            Statement stmt = this.dbConnection.createStatement();
            ResultSet rs = stmt.executeQuery(SQL);
            List<User> userList = new ArrayList<User>();
            while (rs.next()) {
                User user = new User();
                user.setId(rs.getInt("ID"));
                user.setEmail(rs.getString("Email"));
                user.setUsername(rs.getString("Username"));
                user.setName(rs.getString("Name"));
                userList.add(user);
            }
            return userList;
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }

    public User addUser(User newUser) {
        try {
            String SQL = "INSERT INTO person (Username, Password, Email , Name , Role ) VALUES ('"+newUser.getUsername()+ "','"+newUser.getPassword()+"','"+newUser.getEmail()+"','"+newUser.getName()+"','user')";         
            Statement stmt = this.dbConnection.createStatement();
            int resultInsert = stmt.executeUpdate(SQL);

            SQL = "SELECT * FROM person ORDER BY ID DESC LIMIT 1";
            ResultSet rs = stmt.executeQuery(SQL);

            if (rs.next()) {
                User user = new User();
                user.setId(rs.getInt("ID"));
                user.setEmail(rs.getString("Email"));
                user.setName(rs.getString("Name"));
                user.setPassword(rs.getString("Password"));
                user.setUsername(rs.getString("Username"));
                user.setRole("user");
                return user;

            }
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }

    public User updateUser(User newUserInfo) {
        try {
            String SQL = "UPDATE person SET Name='" + newUserInfo.getName() + "',Username='" + newUserInfo.getUsername() + "',Email='" + newUserInfo.getEmail()+ "' WHERE ID=" + newUserInfo.getId();

            Statement stmt = this.dbConnection.createStatement();
            int resultInsert = stmt.executeUpdate(SQL);

            SQL = "SELECT * FROM person WHERE ID= "+ newUserInfo.getId();
            ResultSet rs = stmt.executeQuery(SQL);

            if (rs.next()) {

                User user = new User();
                user.setId(rs.getInt("ID"));
                user.setEmail(rs.getString("Email"));
                user.setName(rs.getString("Name"));
                user.setPassword(rs.getString("Password"));
                user.setUsername(rs.getString("Username"));
                user.setRole("user");
                return user;

            }
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }

    public String deleteUser(int userID) {
        try {
            String SQL = "DELETE FROM person WHERE ID= " + userID ;

            Statement stmt = this.dbConnection.createStatement();
            stmt.executeUpdate(SQL);
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }
    
    
    /**************************
     * BOOK
     * 
     * 
     **************************/
    
    public Book getBook(int id) {
        try {
            String SQL = "SELECT id, title, author, year FROM dbo.Book WHERE id = " + id;
            Statement stmt = this.dbConnection.createStatement();
            ResultSet rs = stmt.executeQuery(SQL);
            if (rs.next()) {
                Book res = new Book();
                res.setId(rs.getLong(1));
                res.setTitle(rs.getString(2));
                res.setAuthor(rs.getString(3));
                res.setYear(rs.getInt(4));
                return res;
            }
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }

    public List<Book> getBookList() {
        try {
            String SQL = "SELECT id, title, author, year FROM dbo.Book";
            Statement stmt = this.dbConnection.createStatement();
            ResultSet rs = stmt.executeQuery(SQL);

            // Iterate through the data in the result set and display it.  
            List<Book> l = new ArrayList<>();
            while (rs.next()) {
                Book res = new Book();
                res.setId(rs.getLong(1));
                res.setTitle(rs.getString(2));
                res.setAuthor(rs.getString(3));
                res.setYear(rs.getInt(4));
                l.add(res);
            }
            return l;
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (this.dbConnection != null) {
                try {
                    this.dbConnection.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return null;
    }

    public boolean createBook(Book b) {
        Connection con = null;
        PreparedStatement preparedStatement = null;
        String insertTableSQL = "INSERT INTO dbo.Book(id, title, author, year) VALUES(?,?,?,?)";
        try {
            if (b != null) {
                preparedStatement = this.dbConnection.prepareStatement(insertTableSQL);
                preparedStatement.setLong(1, b.getId());
                preparedStatement.setString(2, b.getTitle());
                preparedStatement.setString(3, b.getAuthor());
                preparedStatement.setInt(4, b.getYear());
            }

            // execute insert SQL stetement
            if (preparedStatement != null) {
                int res = preparedStatement.executeUpdate();
                return res == 1;
            }
        } catch (SQLException sqle) {
            System.err.println(sqle.getMessage());
        } finally {
            if (preparedStatement != null) {
                try {
                    preparedStatement.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
            if (con != null) {
                try {
                    con.close();
                } catch (SQLException sqle) {
                    System.err.println(sqle.getMessage());
                }
            }
        }
        return false;
    }

}
