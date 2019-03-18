@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <span class="text-capitalize">{{ $title }}</span>
        <small>  <span>{{ $title }}</span> trong cơ sở dữ liệu.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/">Trang chủ</a></li>
        <li><a href="<?=route($controllerName.'.index')?>" class="text-capitalize">{{ ucfirst($title) }}</a></li>
        <li class="active">Hướng dẫn</li>
    </ol>

    <div id="error_div" class="alert alert-warning alert-dismissible" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Thông báo!</h4>
        <span id="error_msg"></span>
    </div>
    <div id="success_div" class="alert alert-success alert-dismissible" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
        <span id="success_msg"></span>
    </div>
</section>

<!-- Main content -->
<section class="content" style="padding-top: 0px;">
    <!-- Default box -->
    <div class="row">
        <!-- THE ACTUAL CONTENT -->
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Hướng dẫn</h3>
                    <div id="datatable_button_stack" class="pull-right text-right hidden-xs"></div>
                </div>
                <div class="box-body overflow-hidden">
                    <!-- start: PAGE CONTENT -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="page_print">
                                <p>Sau khi các bạn setup xong vào trang chính (ví dụ trên máy tôi là http://bds.test.local/panel-kht/crawler).</p>
                                <p><img src="/crawler/images/laytin(2).png" alt="Lấy tin" width="1020" height="294"></p>
                                <p>Đây là giao diện trang lấy tin. Gồm danh sách các mẫu lấy tin tôi đã khai báo sẵn. Các bạn có thể khai báo thêm tùy thích.</p>
                                <p>Bên phải của tên mẫu có đường <strong>link</strong> tới trang muốn lấy, các bạn có thể xem chi tiết.</p>
                                <p>&nbsp;</p>

                                <div class="col-md-6 col-lg-4">
                                    <!--Default Accordion-->
                                    <!--===================================================-->
                                    <div class="panel-group accordion" id="accordion">
                                        <div class="panel">

                                            <!--Accordion title-->
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-parent="#accordion" data-toggle="collapse" href="#collapseOne"><h3>I-Quá trình lấy tin</h3></a>
                                                </h4>
                                            </div>

                                            <!--Accordion content-->
                                            <div class="panel-collapse collapse in" id="collapseOne">
                                                <div class="panel-body">
                                                 <p>Để lấy tin các bạn tich chọn mẫu cần lấy rồi nhấn nút <strong>Lấy tin.</strong> Quá trình lấy tin có thể nhanh hay chậm tùy thuộc vào trang cần lấy, tốc độ mạng …</p>
                                                 <p><img src="/crawler/images/danglaytin(2).png" alt="Đang lấy tin" width="620" height="192"></p>
                                                 <p>Sau khi lấy xong</p>
                                                 <p><img src="/crawler/images/danhsachtindalay(2).png" alt="khi lấy xong tin" width="620" height="203"></p>
                                                 <p>Lúc này dữ liệu đã được lưu vào <strong>Danh sách bài viết đã lấy</strong> mục đích như một bảng tạm cho chúng ta xem bài viết đã được lấy xong trước khi chép qua danh sách bài viết nơi mà chúng sẽ hiển thị ngoài frontend và nút <strong>Đồng bộ danh sách tin tức</strong> sẽ sẵn sàng để bạn ghi dữ liệu đã lấy vào database.</p>
                                                 <p>Lưu ý các bạn phải chọn bài trước khi đồng bộ, chúng ta có thể lọc dữ liệu trước khi đồng bộ, bảng có 1 ô checkbox chọn hết trên cùng bên trái nếu chúng ta muốn chọn tất cả</p>
                                                 <p>Chúng ta có thể nhấp vào các list trong tiêu đề bài viết để đi đến trang chi tiết nơi mà nó đã lấy về. </p>

                                                 <p>Nhấn vào chi tiết một tin để xem chi tiết.</p>
                                                 <p><img src="/crawler/images/chitiettindalay(2).png" alt="chi tiết tin" width="620" height="318"></p>
                                                 <p>Sau khi nhấn nút <strong>Đồng bộ danh sách tin tức </strong>các bạn có thể thấy các tin chúng ta vừa chọn để đồng bộ bên tab <strong>Danh sách bài viết đã lấy</strong> đã được nhóm vào trạng thái đã đồng bộ mục đích là để chúng ta tiện xóa những bài đã đồng bộ</p>
                                                 <p>Và bên tab <strong>Danh sach bài viết</strong> các tin đó sẽ ở trạng thái không kích hoạt mục đích cho chúng ta duyệt lại trước khi kích hoạt</p>
                                                 <p><img src="/crawler/images/danhsachtindalay(3).png" alt="danh sách tin đã lấy" width="620" height="318"></p>


                                             </div>
                                         </div>
                                     </div>
                                     <div class="panel">

                                        <!--Accordion title-->
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-parent="#accordion" data-toggle="collapse" href="#collapseTwo"> <h3>II-Quản lý mẫu lấy tin</h3></a>
                                            </h4>
                                        </div>

                                        <!--Accordion content-->
                                        <div class="panel-collapse collapse" id="collapseTwo">
                                            <div class="panel-body">

                                                <p>Các bạn vào trang <strong>Nhập mẫu</strong> (http://bds.test.local/panel-kht/crawler/create).</p>
                                                <p><img src="/crawler/images/laytin(2).png" alt="Lấy tin" width="1020" height="294"></p>
                                                <p>Để cụ thể tôi sẽ lấy mẫu <strong>http://vietnamnet.vn/vn/bat-dong-san/</strong> làm demo.</p>
                                                <p>Các bạn nhấn vào nút chỉnh sửa mầu xanh dương bên trái mẫu. Từ đây sẽ là mẫu cho các bạn thêm mới</p>
                                                <p><img src="/crawler/images/chitietmotmaulaytin(2).png" alt="chi tiết mẫu lấy tin" width="620" height="282"></p>
                                                <p>Chúng ta mong muốn lấy tin tức từ trang khác có ảnh đại diện, miêu tả, nội dung, ... nên form nhập thông tin sẽ có dạng như trên</p>
                                                <p>Thông tin có dấu <span style="color: #ff0000;">*</span> là bắt buộc phải nhập. Tôi sẽ giải thích từng trường thông tin:</p>
                                                <ol>
                                                    <li><strong>link cần lọc bài:</strong> Là link chứa các list bài mà chúng ta muốn lấy <strong>http://vietnamnet.vn/vn/bat-dong-san/</strong></li>
                                                    <li><strong>Thẻ lấy từng bài:</strong>: Là 1 quy tắc giúp phần mềm hiểu cách vào từng bài cụ thể: <strong>h3 > a</strong></li>
                                                    <li><strong>Url</strong>: Là đường dẫn chính của trang . VD: <strong>http://vietnamnet.vn</strong></li>
                                                    <li><strong>Thẻ lấy hình đại diện</strong>: Là 1 quy tắc giúp phần mềm lấy được hình đại diện của từng bài <strong>li.item.clearfix.dotter > a > img</strong></li>
                                                    <li><strong>Thẻ lấy tiêu đề bài viết</strong>: Là 1 quy tắc giúp phần mềm lấy được tiêu đề của từng bài <strong>h1</strong></li>
                                                    <li><strong>Thẻ lấy mô tả ngắn</strong>: Là 1 quy tắc giúp phần mềm lấy được mô tả ngắn của từng bài <strong>span.bold</strong></li>
                                                    <li><strong>Thẻ lấy nội dung</strong>: Là 1 quy tắc giúp phần mềm lấy được nội dung của từng bài <strong>#ArticleContent</strong></li>
                                                    <li><strong>Loại tin</strong>: Tin bài thuộc tin tức hay phong thủy. VD: <strong>TIn tức</strong>
                                                        <p>Để hiểu rõ cách đặt quy tắc chúng ta cần theo dõi mô tả dưới đây</p>
                                                        <p>Các bạn vào link cần lấy dữ liệu <a href="http://vietnamnet.vn/vn/bat-dong-san/" target="_blank">http://vietnamnet.vn/vn/bat-dong-san/</a></p>
                                                        <p><img src="/crawler/images/vung_can_lay_du_lieu(2).png" alt="vùng cần lấy dữ liệu" width="620" height="318"></p>
                                                        <p>Sau khi xác định được vùng cần lấy ảnh đại diện, các bạn xác định mẫu bao ngoài một đối tượng. Tôi định nghĩa mẫu bao ngoài một đối tượng là mẫu chứa đường link tới trang chi tiết tin và ảnh đại diện của tin.</p>
                                                        <p>Để xác định mẫu bao ngoài một đối tượng các bạn sử dụng <span>Firebug, trên FF hay Chrome , bấm F12 cho nó chạy, <span>Firebug là 1 plugin của FF, Chrome thì có sẵn. Sau đó nhấn chuột phải vào đối tượng cần xem mẫu và chọn <strong>Kiểm tra phần tử</strong> (<span><strong>Inspect Element With Firebug</strong>). Hoặc các bạn có thể làm như sau: Nhấn F12</span><br></span></span></p>
                                                        <p>Với Chrome Trong tab Elements các bạn nhấn vào nút Select an element in the page to inspect it (hình kính lúp bên dưới vị trí thứ 3 từ trái sang)</p>
                                                        <p>Với FF các bạn nhấn nút Select an element in the page to inspect ở vị trí thứ 2 từ trái sang của Firebug.</p>
                                                        <p>Cách lấy ảnh đại diện</p>
                                                        <p><img src="/crawler/images/cach_lay_anh_dai_dien.png" alt="cách lấy ảnh đại diện" width="620" height="318"></p>
                                                        <p>sau đó di chuột vào vùng mẫu bao ngoài một đối tượng mà tôi đã khoanh mầu xanh ở hình trên để đi vào từng bài. Các bạn sẽ thấy như hình dưới:</p>
                                                        <p><img src="/crawler/images/mau_bao_ngoai_mot_doi_tuong(2).png" alt="mẫu bao ngoài một đối tượng" width="620" height="318"></p>
                                                        <p>Các bạn để ý thấy thẻ lấy từng bài sẽ có dạng <strong>h3 > a</strong></p>
                                                        <p>&nbsp;</p>
                                                    </li>
                                                    <li><strong>Mẫu lấy chi tiết tiêu đề </strong>:
                                                        <p>Sau khi xác định được thẻ đi vào từng bài viết, phần mềm sẽ đi vào từng bài viết để lấy dữ liệu cụ thể hơn.</p>
                                                        <p>Các bạn có thể truyền vào thẻ <strong>h1</strong> đối với trang này để lấy tiêu đề bài viết</p>
                                                        <p><img src="/crawler/images/lay_tieu_de_bai_viet.png" alt="lấy tiêu đề bài viết" width="620" height="318"></p>
                                                        <li><strong>Mẫu lấy chi tiết mô tả ngắn </strong>:
                                                            <p>Các bạn có thể truyền vào thẻ <strong>span.bold</strong> đối với trang này để lấy mô tả ngắn</p>
                                                            <p><img src="/crawler/images/lay_mo_ta_ngan_bai_viet.png" alt="lấy mô tả ngắn bài viết" width="620" height="318"></p>
                                                        </li>
                                                        <li><strong>Mẫu lấy chi tiết nội dung</strong>:
                                                           <p>Các bạn có thể truyền vào thẻ <strong>#ArticleContent</strong> đối với trang này để lấy nội dung</p>
                                                           <p><img src="/crawler/images/lay_noi_dung_bai_viet.png" alt="lấy nội dung bài viết" width="620" height="318"></p>
                                                       </li>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="panel">

                                            <!--Accordion title-->
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-parent="#accordion" data-toggle="collapse" href="#collapseThree"><h3>III-Tóm tắt lại :</h3></a>
                                                </h4>
                                            </div>

                                            <!--Accordion content-->
                                            <div class="panel-collapse collapse" id="collapseThree">
                                                <div class="panel-body">
                                                  <p>Từ link ta nhập trong ô <strong>link cần lọc bài </strong>. Ta xác định vùng cần lấy tin đó là một vùng có chứa danh sách tin. Từ vùng đó nhờ tool của trình duyệt ta sẽ xác
                                                    định được 2 thẻ để nhập vào 2 ô <strong>Thẻ lấy từng bài</strong> và <strong>Thẻ lấy hình đại diện</strong></p>
                                                    <p>Thẻ lấy từng bài có dạng: ...> a </p>
                                                    <p>Thẻ lấy từng bài có dạng: ...> a >img</p>
                                                    <p>Sau khi xác định 2 thẻ trên, chúng ta nhấp vào từng bài cụ thể để xác định vùng cần lấy thông tin</p>
                                                    <p>Bằng tool của trình duyệt chúng ta có thể xác định tiếp các thẻ lấy tiêu đề bài viết, mô tả ngắn và nội dung.</p>

                                                </ol>
                                                <p>Sau khi điền xong các bạn nhấn nút <strong>Lưu lại.</strong></p>
                                                <p><strong>Vậy là ta đã khai báo xong một mẫu lấy tin. Các bạn ra trang lấy tin để thử.</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--===================================================-->
                                <!--End Default Accordion-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<style type="text/css">
    .panel-body{
        height: 100%;
         width: 1010px;
        margin: auto;
    }
</style>>
@endsection
