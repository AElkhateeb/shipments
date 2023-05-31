@php 
$calc =array(
    'placeF'=>$data['placeF'],
    'placeT'=>$data['placeT'],
    'road'=>$data['road'],
    'siteOption'=>$data['siteOption'],
) ;
@endphp
@extends('layouts.front')
@section('content')
@section('title', 'Shipping')
@section('description',  'description')
@section('content')
<section>
			
				<div class="container">
				
					<!-- row Start -->
					<div class="dashboard-wraper">
							
								<!-- Bookmark Property -->
								<div class="form-submit <?= (App::currentLocale()=='en')? '': 'arabic'?>">	
									<h4>{{__('front.shipment.title')}}</h4>
								</div>
								
								<table id="shipmentTable" class="property-table-wrap responsive-table bkmark">
									@include('front.shipment-table')									
								</table>
								
							</div>
					<!-- /row -->

					@include('front.calc')				
					
				</div>
						
			</section>

@stop