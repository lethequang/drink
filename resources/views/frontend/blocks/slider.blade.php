<div class="main-slider">
    @foreach($sliders as $item)
    <div class="slide">
        <img src="{{ $item['image_url'] . $item['image'] }}" alt="{{ $item['title'] }}">
    </div>
    @endforeach
</div>