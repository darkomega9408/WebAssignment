<?php
class i18n {
    private $lang;
    public function __construct($lang) {
        $this->lang = $lang;
    }

    // common
    public function web_name() {
      return "Family Tree";
    }
    public function slogan() {
        if ($this->lang == "vi") return "Kết Nối Thế Hệ";
        elseif ($this->lang == "en") return "Connect Generations";
    }

    // homepage
    public function homepage() {
        if ($this->lang == "vi") return "Trang chủ";
        elseif ($this->lang == "en") return "Homepage";
    }
    public function username() {
        if ($this->lang == "vi") return "Tên người dùng";
        elseif ($this->lang == "en") return "Username";
    }
    public function password() {
        if ($this->lang == "vi") return "Mật khẩu";
        elseif ($this->lang == "en") return "Password";
    }
    public function login() {
      if ($this->lang == "vi") return "Đăng nhập";
      elseif ($this->lang == "en") return "Login";
    }
    public function str_or() {
      if ($this->lang == "vi") return "Hoặc";
      elseif ($this->lang == "en") return "Or";
    }
    public function signup() {
      if ($this->lang == "vi") return "Đăng ký";
      elseif ($this->lang == "en") return "Sign up";
    }
    public function services() {
      if ($this->lang == "vi") return "Dịch vụ";
      elseif ($this->lang == "en") return "Services";
    }
    public function what_we_offer() {
      if ($this->lang == "vi") return "Chúng tôi cung cấp";
      elseif ($this->lang == "en") return "What we offer";
    }
    public function create() {
      if ($this->lang == "vi") return "Tạo";
      elseif ($this->lang == "en") return "Create";
    }
    public function create_family_tree() {
      if ($this->lang == "vi") return "Tạo gia phả gia đình bạn";
      elseif ($this->lang == "en") return "Create your own family tree";
    }
    public function modify() {
      if ($this->lang == "vi") return "Chỉnh sửa";
      elseif ($this->lang == "en") return "Modify";
    }
    public function modify_family_tree() {
      if ($this->lang == "vi") return "Chỉnh sửa gia phả gia đình bạn";
      elseif ($this->lang == "en") return "Modify your family tree";
    }
    public function search() {
      if ($this->lang == "vi") return "Tìm kiếm";
      elseif ($this->lang == "en") return "Search";
    }
    public function search_family_tree() {
      if ($this->lang == "vi") return "Tìm kiếm thành viên gia đình bạn";
      elseif ($this->lang == "en") return "Search member in your family";
    }
    public function globe() {
      if ($this->lang == "vi") return "Toàn cầu";
      elseif ($this->lang == "en") return "Globe";
    }
    public function globe_member() {
      if ($this->lang == "vi") return "Tìm kiếm người nhà trên bản đồ";
      elseif ($this->lang == "en") return "Find member address on map";
    }
    public function avatar() {
      if ($this->lang == "vi") return "Ảnh đại diện";
      elseif ($this->lang == "en") return "Avatar";
    }
    public function upload_avatar() {
      if ($this->lang == "vi") return "Chỉnh sửa ảnh đại diện";
      elseif ($this->lang == "en") return "Upload member avatar";
    }
    public function export() {
      if ($this->lang == "vi") return "Xuất khẩu";
      elseif ($this->lang == "en") return "Export";
    }
    public function export_family_tree() {
      if ($this->lang == "vi") return "Xuất khẩu gia phả thành file ảnh";
      elseif ($this->lang == "en") return "Export your family tree image";
    }
    public function about_us() {
      if ($this->lang == "vi") return "Về chúng tôi";
      elseif ($this->lang == "en") return "About us";
    }

    // tree page
    public function tree_owner($name) {
      if ($this->lang == "vi") return "Gia phả của ".$name;
      elseif ($this->lang == "en") return $name."'s tree";
    }
    public function add_member() {
      if ($this->lang == "vi") return "Thêm thành viên";
      elseif ($this->lang == "en") return "Add member";
    }

    // admin page
    public function admin_page() {
        if ($this->lang == "vi") return "Quản trị";
        elseif ($this->lang == "en") return "Admin";
    }
    public function list_users() {
        if ($this->lang == "vi") return "Danh sách người dùng";
        elseif ($this->lang == "en") return "List of users";
    }
    public function list_guests() {
        if ($this->lang == "vi") return "Danh sách khách";
        elseif ($this->lang == "en") return "List of guests";
    }
    public function add_user() {
      if ($this->lang == "vi") return "Thêm người dùng";
      elseif ($this->lang == "en") return "Add user";
    }
    public function add_guest() {
      if ($this->lang == "vi") return "Thêm khách";
      elseif ($this->lang == "en") return "Add guest";
    }

    // nav bar
    public function tree_tab() {
      if ($this->lang == "vi") return "Gia phả";
      elseif ($this->lang == "en") return "Family tree";
    }
    public function management_tab() {
      if ($this->lang == "vi") return "Quản lý";
      elseif ($this->lang == "en") return "Management";
    }
    public function logout() {
      if ($this->lang == "vi") return "Đăng xuất";
      elseif ($this->lang == "en") return "Logout";
    }

    //membercard
    public function detail() {
      if ($this->lang == "vi") return "Chi tiết";
      elseif ($this->lang == "en") return "Detail";
    }
    public function add_child() {
      if ($this->lang == "vi") return "Thêm con cái";
      elseif ($this->lang == "en") return "Add child";
    }
    public function delete() {
      if ($this->lang == "vi") return "Xóa người này";
      elseif ($this->lang == "en") return "Delete this member";
    }

    // member-info-modal
    public function information() {
      if ($this->lang == "vi") return "Thông tin";
      elseif ($this->lang == "en") return "Information";
    }
    public function partner() {
      if ($this->lang == "vi") return "Vợ/Chồng";
      elseif ($this->lang == "en") return "Partner";
    }
    public function member_name() {
      if ($this->lang == "vi") return "Tên";
      elseif ($this->lang == "en") return "Name";
    }
    public function member_gender() {
      if ($this->lang == "vi") return "Giới tính";
      elseif ($this->lang == "en") return "Gender";
    }
    public function male() {
      if ($this->lang == "vi") return "Nam";
      elseif ($this->lang == "en") return "Male";
    }
    public function female() {
      if ($this->lang == "vi") return "Nữ";
      elseif ($this->lang == "en") return "Female";
    }
    public function birth_date() {
      if ($this->lang == "vi") return "Ngày sinh";
      elseif ($this->lang == "en") return "Date of birth";
    }
    public function address() {
      if ($this->lang == "vi") return "Địa chỉ";
      elseif ($this->lang == "en") return "Address";
    }
    public function birth_place() {
      if ($this->lang == "vi") return "Nơi sinh";
      elseif ($this->lang == "en") return "Birthplace";
    }
    public function status() {
      if ($this->lang == "vi") return "Tình trạng";
      elseif ($this->lang == "en") return "Status";
    }
    public function status_alive() {
      if ($this->lang == "vi") return "Còn sống";
      elseif ($this->lang == "en") return "Alive";
    }
    public function status_dead() {
      if ($this->lang == "vi") return "Đã mất";
      elseif ($this->lang == "en") return "Dead";
    }
    public function marital_status() {
      if ($this->lang == "vi") return "Tình trạng hôn nhân";
      elseif ($this->lang == "en") return "Marital status";
    }
    public function marital_status_married() {
      if ($this->lang == "vi") return "Đã kết hôn";
      elseif ($this->lang == "en") return "Married";
    }
    public function marital_status_single() {
      if ($this->lang == "vi") return "Độc thân";
      elseif ($this->lang == "en") return "Single";
    }
    public function update() {
      if ($this->lang == "vi") return "Cập nhật";
      elseif ($this->lang == "en") return "Update";
    }
    public function cancel() {
      if ($this->lang == "vi") return "Hủy";
      elseif ($this->lang == "en") return "Cancel";
    }
    public function add() {
      if ($this->lang == "vi") return "Thêm";
      elseif ($this->lang == "en") return "Add";
    }

    //modal-add-member
    public function new_member() {
      if ($this->lang == "vi") return "Thành viên mới";
      elseif ($this->lang == "en") return "New member";
    }

    // modal-delete-user
    public function delete_prompt() {
      if ($this->lang == "vi") return "Bạn có chắc muốn xóa người này?";
      elseif ($this->lang == "en") return "Are you sure you want to delete this person?";
    }
    public function yes() {
      if ($this->lang == "vi") return "Có";
      elseif ($this->lang == "en") return "Yes";
    }
    public function no() {
      if ($this->lang == "vi") return "Không";
      elseif ($this->lang == "en") return "No";
    }

    // modal-upload
    public function upload() {
      if ($this->lang == "vi") return "Đăng tải";
      elseif ($this->lang == "en") return "Upload";
    }

    // modal edit user
    public function modal_edit_user() {
      if ($this->lang == "vi") return "Chỉnh sửa thông tin";
      elseif ($this->lang == "en") return "Edit user";
    }

    // modal add user
    public function modal_add_user() {
      if ($this->lang == "vi") return "Người dùng mới";
      elseif ($this->lang == "en") return "New user";
    }
    public function confirm_password() {
      if ($this->lang == "vi") return "Xác nhận mật khẩu";
      elseif ($this->lang == "en") return "Confirm password";
    }

    // signup form
}
?>
