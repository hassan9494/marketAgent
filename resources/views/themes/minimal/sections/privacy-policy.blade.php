
@extends('user.layouts.app')
@section('title',__('privacy-policy'))

@section('content')
     <!-- ABOUT-US -->
    {{-- @if(isset($templates['about-us'][0]) && $aboutUs = $templates['about-us'][0]) --}}
    <section id="about-us" class="Privacy-Policy">
        <div class="shape-circle wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.35s">
            <div class="circle"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <h3 class="h3 mb-30">Privacy Policy</h3>
                <p class="text">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium a illo, sapiente suscipit aperiam tenetur ad itaque corrupti obcaecati incidunt distinctio et blanditiis necessitatibus reprehenderit. Facere molestias pariatur ut eveniet.
                </p>
                </div>
            </div>
        </div>
    </section>
    <!-- /ABOUT-US -->



    {{-- @push('extra-content')
        @if($aboutUs->templateMedia()->youtube_link)
            <!-- MODAL-VIDEO -->
            <div id="modal-video">
                <div class="modal-wrapper">
                    <div class="modal-content">
                        <div class="btn-close">&times;</div>
                        <div class="modal-container">
                            <iframe width="100%" height="100%" src="{{@$aboutUs->templateMedia()->youtube_link}}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /MODAL-VIDEO -->
        @endif
    @endpush --}}

    {{-- @endif       --}}
@endsection

