@if ($item)
<!-- Panel Box -->
<div class="panel-box">
    <!-- Panel Header / Title -->
    <div class="panel-header">
        <h3 class="panel-title">Liên hệ</h3>
    </div>
    <!-- Panel Body -->
    <div class="panel-body">
        <div class="profile-box">
            <div class="profile-header">
                <div class="profile-img"><img src="{{ $item['image_url'] . $item['image_location'] }}" alt="{{ $item['name'] }}"></div>
                <h5 class="profile-title">{{ $item['name'] }}</h5>
            </div>
            <ul class="profile-contact">
                <li><i class="fa fa-envelope"></i> <a href="mailto:{{ $item['email'] }}">{{ $item['email'] }}</a></li>
                <li><i class="fa fa-phone"></i> <a href="tel:{{ $item['phone'] }}">{{ $item['phone'] }}</a></li>
            </ul>
        </div>
    </div>
</div>
@endif