package vn.khmt.hello.restful;

import java.io.IOException;
import java.util.List;
import javax.ws.rs.Consumes;
import javax.ws.rs.GET;
import javax.ws.rs.HeaderParam;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.core.GenericEntity;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import org.codehaus.jackson.annotate.JsonProperty;
import org.codehaus.jackson.map.ObjectMapper;
import org.codehaus.jackson.type.TypeReference;
import org.codehaus.jettison.json.JSONException;
import org.codehaus.jettison.json.JSONObject;
import vn.khmt.db.ConnectToSQL;

@Path("/webservice")
public class HelloService {

    String host = "localhost";
    String dbname = "bibli";
    String user = "nhanbk";
    String pass = "nhanbk";

    @POST
    @Path("giapha/getmembers")
    @Produces(MediaType.APPLICATION_JSON)
    public Response giapha(JSONObject input, @HeaderParam("authorization") String authString) throws JSONException {

        User user = AuthenticationService.authenticate(authString);
        if (user != null) {
            String role = user.getRole();
            int userID = user.getId();

            ConnectToSQL db = new ConnectToSQL(ConnectToSQL.MYSQL, "localhost", "webassignment", "root", "");
            GenericEntity genEntity;
            
            if( role.equals("admin") ){
                List<User> userList = db.getUsers();
                if (userList != null) {
                    genEntity = new GenericEntity<List<User>>(userList) {
                    };
                    return Response.status(Response.Status.OK).entity(genEntity).build();
                } else {
                    return Response.status(Response.Status.OK).entity("{\"status\":\"Failed to get member\"}").build();
                }
            }
            else if (role.equals("user")) {
                List<Member> memberList = db.getMembers(userID);
                if (memberList != null) {
                    genEntity = new GenericEntity<List<Member>>(memberList) {
                    };
                    return Response.status(Response.Status.OK).entity(genEntity).build();
                } else {
                    return Response.status(Response.Status.OK).entity("{\"status\":\"Failed to get member list\"}").build();
                }
            }
        }

        return Response.status(Response.Status.OK).entity("{\"status\":\"Failed to get member list\"}").build();
    }

    @POST
    @Path("giapha/addmember")
    @Consumes(MediaType.APPLICATION_JSON)
    @Produces(MediaType.APPLICATION_JSON)
    public Response addmem(JSONObject input, @HeaderParam("authorization") String authString) throws JSONException, IOException {

        User user = AuthenticationService.authenticate(authString);
        if (user != null) {
            String role = user.getRole();
            
            ConnectToSQL db = new ConnectToSQL(ConnectToSQL.MYSQL, "localhost", "webassignment", "root", "");
            
            if (role.equals("user")) {                
                JSONObject newMemJson = input.getJSONObject("sentData");
                newMemJson.put("userID", user.getId());
                ObjectMapper mapper = new ObjectMapper();
                Member newMem = mapper.readValue(newMemJson.toString(), new TypeReference<Member>() {
                });
                return Response.status(Response.Status.OK).entity(db.addMember(newMem)).build();
            }
            else if (role.equals("admin")){
                JSONObject newMemJson = input.getJSONObject("sentData");
                
                ObjectMapper mapper = new ObjectMapper();
                User newMem = mapper.readValue(newMemJson.toString(), new TypeReference<User>() {
                });
                return Response.status(Response.Status.OK).entity(db.addUser(newMem)).build();
            }
        }

        return Response.status(Response.Status.OK).entity("{\"status\":\"Failed to add new member\"}").build();

    }

    @POST
    @Path("giapha/deletemember")
    @Consumes(MediaType.APPLICATION_JSON)
    public Response deletemem(JSONObject input, @HeaderParam("authorization") String authString) throws JSONException {

        User user = AuthenticationService.authenticate(authString);

        if (user != null) {
            String role = user.getRole();
            ConnectToSQL db = new ConnectToSQL(ConnectToSQL.MYSQL, "localhost", "webassignment", "root", "");
            
            if (role.equals("user")) {
                
                JSONObject memInfo = input.getJSONObject("sentData");
                return Response.status(Response.Status.OK).entity(db.deleteMember(user.getId(), memInfo.getInt("MemberID"))).build();
            }
            else if (role.equals("admin")){
                JSONObject memInfo = input.getJSONObject("sentData");
                return Response.status(Response.Status.OK).entity(db.deleteUser(memInfo.getInt("id"))).build();
            }
        }

        return Response.status(Response.Status.OK).entity("Failed to delete member").build();

    }

    @POST
    @Path("giapha/updatemember")
    @Consumes(MediaType.APPLICATION_JSON)
    @Produces(MediaType.APPLICATION_JSON)
    public Response updatemem(JSONObject input, @HeaderParam("authorization") String authString) throws JSONException, IOException {

        User user = AuthenticationService.authenticate(authString);

        if (user != null) {
            String role = user.getRole();
            ConnectToSQL db = new ConnectToSQL(ConnectToSQL.MYSQL, "localhost", "webassignment", "root", "");
            
            if (role.equals("user")) {
                
                JSONObject newMemJson = input.getJSONObject("sentData");
                newMemJson.put("userID", user.getId());
                ObjectMapper mapper = new ObjectMapper();
                Member newMem = mapper.readValue(newMemJson.toString(), new TypeReference<Member>() {
                });
                return Response.status(Response.Status.OK).entity(db.updateMember(newMem)).build();
            }
            else if (role.equals("admin")){
                JSONObject newMemJson = input.getJSONObject("sentData");
                ObjectMapper mapper = new ObjectMapper();
                User newMem = mapper.readValue(newMemJson.toString(), new TypeReference<User>() {
                });
                return Response.status(Response.Status.OK).entity(db.updateUser(newMem)).build();
            }
        }

        return Response.status(Response.Status.OK).entity("{\"status\":\"Failed to update new member\"}").build();

    }
    
    @POST
    @Path("giapha/changeavatar")
    @Consumes(MediaType.APPLICATION_JSON)
    @Produces(MediaType.APPLICATION_JSON)
    public Response changememavatar(JSONObject input, @HeaderParam("authorization") String authString) throws JSONException{

        User user = AuthenticationService.authenticate(authString);

        if (user != null) {
            String role = user.getRole();
            if (role.equals("user")) {
                ConnectToSQL db = new ConnectToSQL(ConnectToSQL.MYSQL, "localhost", "webassignment", "root", "");
                JSONObject newMemJson = input.getJSONObject("sentData");
                return Response.status(Response.Status.OK).entity(db.changeMemberAvatar(user.getId(), newMemJson.getInt("memberID"), newMemJson.getString("avatar"))).build();
            }
        }

        return Response.status(Response.Status.OK).entity("{\"status\":\"Failed to update new avatar for member\"}").build();

    }

    @POST
    @Produces(MediaType.APPLICATION_JSON)
    @Path("giapha/checkuser")
    public Response checkuser(@HeaderParam("authorization") String authString) throws JSONException {
        /*
        User user = AuthenticationService.authenticate(authString);
        if (user != null)
            return Response.status(Response.Status.OK).entity(AuthenticationService.authenticate(authString)).build();
        else*/
        return Response.status(Response.Status.OK).entity(AuthenticationService.authenticate(authString)).build();

    }

    @GET
    @Path("/{param}")
    public Response hello(@PathParam("param") String name) {
        String msg = "Hello " + name;
        return Response.status(Response.Status.OK).entity(msg).build();
    }

    @GET
    @Path("/json/{param}")
    @Produces(MediaType.APPLICATION_JSON)
    public Response helloInJSON(@PathParam("param") String name) {
        String msg = "{\"message\" : \"Hello " + name + "\"}";
        return Response.status(Response.Status.OK).entity(msg).build();
    }

    @GET
    @Path("/book/get")
    @Produces(MediaType.APPLICATION_JSON)
    public Response book() {
        Book b = new Book();
        b.setId(1);
        b.setAuthor("Nguyen Nhat Anh");
        b.setTitle("Toi thay hoa vang");
        b.setYear(2012);
        return Response.status(Response.Status.OK).entity(b).build();
    }

    @GET
    @Path("/book/{id}")
    @Produces(MediaType.APPLICATION_JSON)
    public Response book(@PathParam("id") int id) {
        ConnectToSQL db = new ConnectToSQL(ConnectToSQL.SQLSERVER, host, dbname, user, pass);
        Book b = db.getBook(id);
        return Response.status(Response.Status.OK).entity(b).build();
    }

    @GET
    @Path("/book/all")
    @Produces(MediaType.APPLICATION_JSON)
    public Response bookList() {
        ConnectToSQL db = new ConnectToSQL(ConnectToSQL.SQLSERVER, host, dbname, user, pass);
        List<Book> bl = db.getBookList();
        return Response.status(Response.Status.OK).entity(new GenericEntity<List<Book>>(bl) {
        }).build();
        //return Response.status(Response.Status.OK).entity(bl).build();
    }

    @POST
    @Path("/post")
    @Consumes(MediaType.TEXT_PLAIN)
    public Response receiveMessage(String message) {
        System.out.println("Message received = " + message);
        return Response.status(Response.Status.CREATED).entity("Message received").build();
    }

    @POST
    @Path("/postJSON")
    @Consumes(MediaType.APPLICATION_JSON)
    public Response receiveBook(Book b) {
        ConnectToSQL db = new ConnectToSQL(ConnectToSQL.SQLSERVER, host, dbname, user, pass);
        db.createBook(b);
        return Response.status(Response.Status.CREATED).entity("Book created").build();
    }
}
