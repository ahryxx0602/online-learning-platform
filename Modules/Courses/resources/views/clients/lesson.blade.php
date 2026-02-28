@foreach (getModuleByPosition($course) as $key => $module)
    <div class="accordion-group">
        <h4 class="accordion-title {{$key == 0 ? 'active' : ''}} ">{{ $module->name }}</h4>
        <div class="accordion-detail" 
            style=" {{$key == 0 ? 'display: block;' : ''}} ">
            @foreach (getLessonsByPosition($course, $module->id) as $lesson )
                @if ($lesson->parent_id == $module->id)
                <div class="card-accordion">
                    <div>
                        <i class="fa-brands fa-youtube"></i>
                        {{"Bài " .($index++) .": ".$lesson->name}}
                        @if($lesson->is_trial)
                            <p class="trial-btn" data-id="{{ $lesson->id }}">Học thử</p>
                        @endif
                        <span>{{ getTime($lesson->duration) }}</span>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
@endforeach
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const trialBtnList = document.querySelectorAll('.trial-btn');
        const modalEl = document.querySelector('#modal');
        
        if (!modalEl) {
            console.error('Không tìm thấy khối HTML có id="modal". Vui lòng kiểm tra lại file Blade.');
            return;
        }

        const modal = new bootstrap.Modal(modalEl);
        
        if(trialBtnList.length){
            trialBtnList.forEach((trialBtn) => {
                trialBtn.addEventListener('click', (e) => {
                    const btn = e.currentTarget; 
                    const id = btn.dataset.id; 
                    
                    // --- 1. HIỆU ỨNG TRÊN NÚT BẤM ---
                    const originalText = btn.innerHTML; // Lưu lại HTML ban đầu của nút
                    btn.innerText = 'Đang mở...';
                    btn.style.pointerEvents = 'none'; // Chặn click liên tiếp
                    btn.style.opacity = '0.6'; // Làm mờ nút đi một chút
                    
                    let url = "{{ route('courses.data.trial', ':id') }}";
                    url = url.replace(':id', id);
                    
                    // --- 2. HIỆU ỨNG LOADING TRONG MODAL ---
                    modalEl.querySelector('.modal-title').innerText = 'Đang tải dữ liệu...';
                    modalEl.querySelector('.modal-body').innerHTML = `
                        <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 250px;">
                            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Đang tải video, vui lòng chờ trong giây lát...</p>
                        </div>
                    `;
                    modal.show();
                    
                    // Hàm dùng chung để khôi phục lại trạng thái nút ban đầu
                    const resetButton = () => {
                        btn.innerHTML = originalText;
                        btn.style.pointerEvents = 'auto';
                        btn.style.opacity = '1';
                    };

                    fetch(url).then((response) => {
                        if(!response.ok) throw new Error('Lỗi mạng hoặc 404 Not Found');
                        return response.json();
                    }).then(({success, data}) => {
                        
                        resetButton(); // Khôi phục nút khi có phản hồi

                        if(!success){
                            alert('Bài giảng không tồn tại');
                            modal.hide();
                            return;
                        }
                        if(data.is_trial != 1){
                            alert('Không được phép học thử');
                            modal.hide();
                            return;
                        } 
                        
                        const name = data.name;
                        const videoUrl = data.video ? data.video.url : null; 
                        
                        modalEl.querySelector('.modal-title').innerText = name;
                        
                        if (videoUrl) {
                            modalEl.querySelector('.modal-body').innerHTML = `
                                <video src="${videoUrl}" width="100%" height="450" controls autoplay></video>
                            `;
                        } else {
                            modalEl.querySelector('.modal-body').innerHTML = '<p class="text-danger text-center">Video đang được cập nhật.</p>';
                        }
                    }).catch((error) => {
                        resetButton(); // Khôi phục nút nếu có lỗi mạng
                        
                        console.error('Lỗi lấy dữ liệu:', error);
                        alert('Đã có lỗi xảy ra hoặc không tìm thấy đường dẫn (404).');
                        modal.hide();
                    });
                })
            });

            // Reset modal khi đóng
            modalEl.addEventListener('hidden.bs.modal', event => {
                modalEl.querySelector('.modal-body').innerHTML = '';
                modalEl.querySelector('.modal-title').innerHTML = '';
            });
        }
    });
</script>
@endsection