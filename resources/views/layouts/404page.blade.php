@extends('layouts.app')

@section('content')
<section class="page_404">
	<div class="container">
		<div class="row">	
            <div class="col-sm-12">
                <div class="col-sm-10 col-sm-offset-1  text-center">
                    <div class="four_zero_four_bg">
                        <h1 class="text-center">404</h1>
                    </div>
                    
                    <div class="contant_box_404">
                        <h3 class="h2">
                        Het lijkt erop dat je de weg kwijt bent
                        </h3>
                        
                        <p>De pagina die je probeert te bezoeken is niet beschikbaar!</p>
                        
                        <a href="/" class="btn btn-primary link_404">Naar homepagina</a>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>
@endsection

<style>

.page_404 { 
    padding: 40px 0; 
    text-align: center;
}

.page_404  img { 
    width: 100%;
}

.four_zero_four_bg {
    background-image: url("{{ asset('images/404-bg.gif') }}");
    background-repeat: no-repeat;
    height: 400px;
    background-position: center;
 }
 
 
.four_zero_four_bg h1 {
    font-size:80px;
}
 
.four_zero_four_bg h3 {
    font-size:80px;
}
			 
.link_404 {			 
    border-radius: 0px !important;
    padding: 10px 40px !important;
    margin: 20px 0px !important;
}

.contant_box_404 { 
    margin-top: -50px;
}
</style>