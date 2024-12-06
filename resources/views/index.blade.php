@extends('layouts.app')

@section('title', __('mess.home'))

@section('content')
<div class="container">
    <header class="my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-5">
                <h5>{{ __('mess.welcome') }}</h5>
                <span class="text-muted fs-12">{{ __('mess.welcome_desc') }}</span>
            </div>
            <div class="col-5">
                <h5>{{ auth()->user()->full_name }}</h5>
                <span class="badge bg-danger w-100">
                    $ {{ auth()->user()->balance }}
                </span>
            </div>
            <div class="col-2">
                <img src="{{ asset('images/avat.png') }}" alt="avatar" class="img-fluid" width="50" height="50">
            </div>
        </div>
    </header>

    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <!-- <div class="swiper-slide">
                <img src="{{ asset('images/banner1.jpg') }}" alt="banner" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('images/banner2.jpg') }}" alt="banner" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('images/banner3.jpg') }}" alt="banner" class="img-fluid">
            </div> -->
            @foreach ($banner as $item)
            <div class="swiper-slide">
                <img src="{{ asset('storage/'.$item->image) }}" alt="banner" class="img-fluid">
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="row my-3">
        <div class="col-3 text-center">
            <a href="" id="lucky-spin" class="text-decoration-none text-dark">
                <img src="{{ asset('images/vi.png') }}" alt="icon" width="70" height="70">
                <p class="fs-14">{{ __('mess.lucky_spin') }}</p>
            </a>
        </div>
        <div class="col-3 text-center">
            <a href="" class="text-decoration-none text-dark" id="profit-wallet">
                <img src="{{ asset('images/vi2.png') }}" alt="icon" width="70" height="70">
                <p class="fs-14">{{ __('mess.profit_wallet') }}</p>
            </a>
        </div>
        <div class="col-3 text-center">
            <a href="{{ route('deposit.index') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/nap.png') }}" alt="icon" width="70" height="70">
                <p class="fs-14">{{ __('mess.deposit') }}</p>
            </a>
        </div>
        <div class="col-3 text-center">
            <a href="{{ route('withdraw.index') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/rut.png') }}" alt="icon" width="70" height="70">
                <p class="fs-14">{{ __('mess.withdraw') }}</p>
            </a>
        </div>
    </div>

    <div class="row">
        <h5 class="mb-3">{{ __('mess.task_room') }}</h5>
        @foreach ($levels as $level)
        <div class="col-6 my-3">
            <div class="card position-relative" style="background-color: hsla(180,4%,95%,.6)">
                <img src="{{ asset($level->image) }}" width="120" height="120" alt="task" class="img-fluid" style="position: absolute; top: -20px; left: 0;">
                <div class="card-body position-relative">
                    <h6 class="card-title fw-bold">{{ __('mess.commission') }} {{ $level->commission }}%</h6>
                    <p class="card-text fs-12">{{ $level->description }}</p>
                    <img src="{{ asset('images/logo.png') }}" alt="join" class="img-fluid">
                    <!-- // làm mờ  -->
                    @if (auth()->user()->level_id < $level->id)
                        <div class="position-absolute bottom-0 end-0 d-flex justify-content-center align-items-center flex-column py-2" style="background-color: rgba(0,0,0,0.5); width: 100%; height: 50%;">
                            <img src="{{ asset('images/lock.png') }}" alt="join" class="img-fluid" style="width: 30px; height: 30px;">
                            <p class="text-white fs-12">{{ __('mess.waiting_upgrade') }}</p>
                        </div>
                        @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mb-3">
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/about.png') }}" alt="about" class="img-fluid" data-bs-toggle="modal" data-bs-target="#aboutModal">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/des.png') }}" alt="description" class="img-fluid" data-bs-toggle="modal" data-bs-target="#descriptionModal">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/taichinh.png') }}" alt="taichinh" class="img-fluid" data-bs-toggle="modal" data-bs-target="#taichinhModal">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/vanhoa.png') }}" alt="vanhoa" class="img-fluid" data-bs-toggle="modal" data-bs-target="#vanhoaModal">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/dieukien.png') }}" alt="dieukien" class="img-fluid" data-bs-toggle="modal" data-bs-target="#dieukienModal">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/mauthunhap.png') }}" alt="mauthunhap" class="img-fluid" data-bs-toggle="modal" data-bs-target="#mauthunhapModal">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/phanchianhom.png') }}" alt="phanchianhom" class="img-fluid" data-bs-toggle="modal" data-bs-target="#phanchianhomModal">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/chínhachcanhan.png') }}" alt="chínhachcanhan" class="img-fluid" data-bs-toggle="modal" data-bs-target="#chínhachcanhanModal">
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h6 class="mb-3">{{ __('mess.income_list') }}</h6>
            <div id="list-income">

            </div>
        </div>
    </div>


</div>
<div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                <p>{{ __('mess.about') }}</p>
                <p>{{ __('mess.about_2') }}</p>
                <p>{{ __('mess.about_3') }}</p>
                <p>{{ __('mess.about_4') }}</p>
                <p>{{ __('mess.about_5') }}</p>
                <p>{{ __('mess.about_6') }}</p>
                <p>{{ __('mess.about_7') }}</p>
                <p>{{ __('mess.about_8') }}</p>
                <p>{{ __('mess.about_9') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                <p>{{ __('mess.description_1') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="taichinhModal" tabindex="-1" aria-labelledby="taichinhModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                <p>{{ __('mess.taichinh_1') }}</p>
                <p>{{ __('mess.taichinh_2') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="vanhoaModal" tabindex="-1" aria-labelledby="vanhoaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                <p>{{ __('mess.vanhoa_1') }}</p>
                <p>{{ __('mess.vanhoa_2') }}</p>
                <p>{{ __('mess.vanhoa_3') }}</p>
                <p>{{ __('mess.vanhoa_4') }}</p>
                <p>{{ __('mess.vanhoa_5') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dieukienModal" tabindex="-1" aria-labelledby="dieukienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                <div class="bg-[#fff] text-2xl rounded-2xl py-4 px-4 leading-10"><span>Điều khoản sử dụng</span><br><br><span>Các điều khoản sử dụng này quy định sự tương tác giữa các đánh giá của AeonMall Group và các cá nhân truy cập trang web</span><br><br><span>Một. Mục lục <br> Trang web này chứa thông tin, bài báo, bản tin và bản tin, tin tức, liên kết đến các trang web điện tử bên ngoài, và nhiều hình ảnh (nội dung) khác nhau từ AeonMall Group và các luật sư của nó.</span><br><br><span> Thông tin của AeonMall Group và luật sư của nó có thể được xem trên trang web điện tử. Nếu không có sự cho phép rõ ràng hoặc lợi ích hợp pháp liên quan đến việc sử dụng các dịch vụ pháp lý hoặc truyền thông chuyên nghiệp, người dùng sẽ không phải là đối tượng của các hoạt động điều trị.</span><br><br><span>Các bài báo và bản tin thể hiện ý kiến chuyên môn của tác giả về một chủ đề cụ thể tại thời điểm xuất bản và phải được giải thích dựa trên ngày xuất bản. Chúng không đại diện cho ý kiến hoặc khuyến nghị pháp lý nếu không có hướng dẫn chính thức của AeonMall Group đánh giá.</span><br><br><span>Tin tức đại diện cho các tường thuật thực tế, có thể có hoặc không bao gồm các ý kiến do AeonMall Group đánh giá, hoặc phổ biến các sự kiện sắp tới. Sự kiện có thể được thay đổi hoặc hủy bỏ thông qua đánh giá của AeonMall Group mà không cần phải cập nhật trang điện tử trước. Việc giải thích tin tức phải phù hợp với việc giải thích bài báo và bản tin.</span><br><br><span> Để thuận tiện cho người dùng, các liên kết đến các trang web điện tử bên ngoài có thể được cung cấp. Nội dung của nó không được đánh giá bởi AeonMall Group . Các hình ảnh khác nhau nhằm minh họa thông tin được truyền qua trang web điện tử, làm cho nó trở nên thú vị và thân thiện hơn với người dùng.Trừ khi được ủy quyền rõ ràng bởi AeonMall Group hoặc tác giả của nó, việc sao chép toàn bộ hoặc một phần đều bị cấm. Hình ảnh công cộng sẽ được nhận dạng đúng.</span><br><br><span>2 Sở hữu trí tuệ <br> Tất cả nội dung là tài sản trí tuệ của AeonMall Group, trừ khi nội dung thuộc sở hữu của bên thứ ba và bên thứ ba đã đồng ý sao chép cụ thể nội dung trên trang web điện tử hoặc trong phạm vi công cộng.</span><br><br><span>Chức năng của nội dung này là để thông báo cho người dùng rằng nó không nên được sử dụng theo bất kỳ cách nào khác, trừ khi được AeonMall Group cho phép rõ ràng. Việc người dùng sử dụng hợp pháp nội dung bao gồm cả việc đọc và xem trên các trang web điện tử. Cụ thể, đối với các bài báo và bản tin và bản tin, việc sử dụng hợp pháp cũng bao gồm (i) dỡ bỏ và lưu trữ; (2) in ấn (3 chia sẻ vật lý hoặc kỹ thuật số, nhưng nó phải được đề cập và / hoặc liên kết với một trang web điện tử, và không dành cho doanh nghiệp và (iv) Theo quy định của ABN AMRO, các trích dẫn chỉ ra tác giả và địa điểm tham quan.</span><br><br><span>3. Chính sách bảo mật <br>Đánh giá AeonMall Group có chính sách bảo mật quy định việc xử lý dữ liệu cá nhân của người dùng.</span><br><br><span>4. AeonMall Group Đánh giá trách nhiệm <br> Đánh Giá AeonMall Group không chịu trách nhiệm về những thiệt hại mà người dùng có thể phải gánh chịu trong quá trình tương tác với website điện tử..</span><br><br><span>5. Trách nhiệm của người dùng <br>Người dùng cam kết tuân thủ nghiêm ngặt các điều khoản sử dụng này và chịu trách nhiệm về mối quan hệ nhân quả giữa bất kỳ thiệt hại nào được AeonMall Group đánh giá do không tuân thủ các điều khoản sử dụng này.</span></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mauthunhapModal" tabindex="-1" aria-labelledby="mauthunhapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                <div class="bg-[#fff] text-2xl rounded-2xl py-4 px-4 leading-10"><span>Mỗi thành viên được hưởng hoa hồng từ 8% -16% tiền gốc. Mọi tài khoản sẽ gặp từ 0 đến 3 đơn hàng nhiệm vụ may mắn, và nhận thưởng 10%-20%</span></div>
            </div>
            </p>
        </div>
    </div>
</div>
<div class="modal fade" id="phanchianhomModal" tabindex="-1" aria-labelledby="phanchianhomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                <div class="bg-[#fff] text-2xl rounded-2xl py-4 px-4 leading-10"><span>Mỗi thành viên được hưởng hoa hồng từ 8% -16% tiền gốc. Mọi tài khoản sẽ gặp từ 0 đến 3 đơn hàng nhiệm vụ may mắn, và nhận thưởng 10%-20%</span></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="chínhachcanhanModal" tabindex="-1" aria-labelledby="chínhachcanhanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                <div class="bg-[#fff] text-2xl rounded-2xl py-4 px-4 leading-10"><span>3 cấp Phân phối là mô hình phân phối nhiều cấp, có thể đạt được sự phân hóa lớn nhất trong mô hình phân phối, tuyển thêm nhà phân phối để bán và tạo nền tảng vững chắc cho việc hình thành đội bán hàng; sau đó hoa hồng được ấn định theo danh mục hàng hóa , và thông qua hai loại hoa hồng (tăng hoa hồng và hoa hồng bán hàng), không chỉ có thể kích thích các nhà phân phối phát triển phân phối và bán hàng hóa, mà còn cung cấp hỗ trợ kỹ thuật và nền tảng mô hình cho Great Fission. Sau đây mô tả sơ đồ mô hình tiền thưởng của nhóm phân phối ba cấp và phân phối lợi nhuận của mô hình phân phối ba cấp/span></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dieukienModal" tabindex="-1" aria-labelledby="dieukienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                <div class="bg-[#fff] text-2xl rounded-2xl py-4 px-4 leading-10"><span> Nhiều sản phẩm được phép bán ở Hoa Kỳ bị cấm bán trên nền tảng AeonMall Group, chẳng hạn như thuốc giảm cân. Vì vậy, người bán hàng trên AeonMall Group cần tìm hiểu đầy đủ trước khi mở cửa hàng.</span><br><br><span>· Các sản phẩm bị AeonMall Group cấm [6]: <br> Ví dụ: ma túy và các vật tư liên quan, các sản phẩm liên quan đến y tế, súng, đạn dược và chất nổ, vũ khí bị kiểm soát, vật tư cảnh sát, sản phẩm gián điệp, thiết bị y tế, thiết bị làm đẹp và sản phẩm chăm sóc sức khỏe, sản phẩm rượu và thuốc lá, v.v.</span><br><br><span>· Hàng hóa bị hạn chế: <br> Hàng hóa bị hạn chế đề cập đến việc cần phải được phê duyệt trước, vận hành chứng từ hoặc giấy phép kinh doanh được ủy quyền để bán hàng hóa trước khi xuất bản hàng hóa, nếu không thì không được phép xuất bản. Nếu bạn đã có được chứng chỉ giấy phép hợp pháp có liên quan, vui lòng cung cấp chứng chỉ đó cho nền tảng AeonMall Group trước.</span><br><br><span>.Dùng hàng <br> Trên nền tảng AeonMall Group, người dùng bị nghiêm cấm xuất bản và bán các sản phẩm liên quan đến quyền sở hữu trí tuệ của bên thứ ba mà không được phép, bao gồm nhưng không giới hạn ở ba danh mục:</span><br><br><span> 1. Xâm phạm nhãn hiệu: mà không được phép của chủ sở hữu nhãn hiệu, việc sử dụng nhãn hiệu trùng hoặc tương tự với nhãn hiệu đã đăng ký đã được phê duyệt trên cùng một hàng hoá hoặc hàng hoá tương tự đã được quyền nhãn hiệu chấp thuận và các điều luật khác làm tổn hại đến quyền hợp pháp của hành vi của chủ sở hữu nhãn hiệu;</span><br><br><span>2. Vi phạm quyền tác giả: sử dụng tác phẩm của người khác hoặc thực hiện độc quyền của chủ sở hữu quyền tác giả mà không được chủ sở hữu quyền tác giả đồng ý, không có căn cứ pháp luật và có các hành vi khác làm tổn hại đến quyền và lợi ích hợp pháp của chủ sở hữu quyền tác giả theo quy định theo luật</span><br><br><span> 3. Vi phạm bằng sáng chế: không được phép của người được cấp bằng sáng chế, nhằm mục đích sản xuất và vận hành, hành vi bất hợp pháp để thực hiện một bằng sáng chế hợp lệ được pháp luật bảo vệ Để biết nội dung chi tiết, hãy xem phần đọc mở rộng: "Vùng Sở hữu Trí tuệ AeonMall Group"</span></div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .swiper {
        max-width: 500px;
        height: 250px;
    }
</style>
@endpush
@push('script')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 1500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    // random income phone
    function randomIncomePhone() {
        const number3 = ['03', '05', '07', '08', '09'];
        const number4 = ['8', '9'];
        const number5 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const number6 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const number7 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const number8 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const number9 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const number10 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return number3[Math.floor(Math.random() * number3.length)] + number4[Math.floor(Math.random() * number4.length)] + number5[Math.floor(Math.random() * number5.length)] + number6[Math.floor(Math.random() * number6.length)] + number7[Math.floor(Math.random() * number7.length)] + number8[Math.floor(Math.random() * number8.length)] + number9[Math.floor(Math.random() * number9.length)];
    }

    // random income amount
    function randomIncomeAmount() {
        return Math.random() * 100;
    }
    const formatNumber = (number) => {
        return number.toFixed(2);
    }
    //format number phone che 4 số giữa
    const formatNumberPhone = (phone) => {
        return phone.slice(0, 3) + '****' + phone.slice(-3);
    }
    for (let i = 0; i < 10; i++) {
        $('#list-income').append(`
            <div class="row mb-3">
                <div class="col-4">
                    <strong>${formatNumberPhone(randomIncomePhone())}</strong>
                </div>
                <div class="col-4">
                    <span class="badge bg-success">{{ __('mess.income') }} $${formatNumber(randomIncomeAmount())}</span>
                </div>
                <div class="col-4 text-end">
                    <span class="fs-12">${new Date().toLocaleDateString()}</span>
                </div>
            </div>
            `);
    }

    setInterval(() => {
        $('#list-income').html('');
        for (let i = 0; i < 10; i++) {
            $('#list-income').append(`
            <div class="row mb-3">
                <div class="col-4">
                    <strong>${formatNumberPhone(randomIncomePhone())}</strong>
                </div>
                <div class="col-4">
                    <span class="badge bg-success">{{ __('mess.income') }} $${formatNumber(randomIncomeAmount())}</span>
                </div>
                <div class="col-4 text-end">
                    <span class="fs-12">${new Date().toLocaleDateString()}</span>
                </div>
            </div>
            `);
        }
    }, 3000);

    $('#lucky-spin').click((e) => {
        e.preventDefault();
        $('#card-loading').removeClass('d-none');
        $('#message-loading').text("{{ __('mess.processing') }}");
        const progress = $('#progress-loading');
        progress.css('width', '0%');
        progress.animate({
            width: '100%'
        }, 3000);
        setTimeout(() => {
            $('#message-loading').text("{{ __('mess.not_spin') }}");
            $('#icon-loading').removeClass('fa-spin');
            $('#icon-loading').addClass('fa-solid fa-check');
        }, 3000);
    });
    $('#profit-wallet').click((e) => {
        e.preventDefault();
        $('#card-loading').removeClass('d-none');
        $('#message-loading').text("{{ __('mess.processing') }}");
        const progress = $('#progress-loading');
        progress.css('width', '0%');
        progress.animate({
            width: '100%'
        }, 3000);
        setTimeout(() => {
            // $('#card-loading').addClass('d-none');
            $('#message-loading').text("{{ __('mess.developing') }}");
            $('#icon-loading').removeClass('fa-spin');
            $('#icon-loading').addClass('fa-solid fa-check');
        }, 3000);
    });
</script>
@endpush
