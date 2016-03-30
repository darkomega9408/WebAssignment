/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package vn.khmt.hello.restful;

import java.io.IOException;
import java.util.Base64;
import java.util.StringTokenizer;
import vn.khmt.db.ConnectToSQL;

/**
 *
 * @author Darka
 */
public class AuthenticationService {
    
    public static User authenticate(String authCredentials){
        if( authCredentials == null )
            return null;
        
        final String encodedUserPwd = authCredentials.replaceFirst("Basic ", "");
        String userNameAndPwd = null;
        
        try{
            
            byte[] decodedBytes = Base64.getDecoder().decode(encodedUserPwd);
            userNameAndPwd = new String(decodedBytes,"UTF-8");   
        }
        catch(IOException e){
            e.printStackTrace();
        }
        
        final StringTokenizer tokenizer = new StringTokenizer(userNameAndPwd,":");
        final String userName = tokenizer.nextToken();
        final String pwd = tokenizer.nextToken();
        
        // Check special user with name and password equal to "admin"
        if( userName.equals("admin") && pwd.equals("admin") ){
            User user = new User();
            user.setRole("admin");
            return user;
        }
        
        // Otherwise check as usual
        ConnectToSQL db = new ConnectToSQL(ConnectToSQL.MYSQL, "localhost", "webassignment", "root", "");
        User user = db.checkUser(userName, pwd);
        if (user != null)
            return user;
        
        return null;
    }
}
