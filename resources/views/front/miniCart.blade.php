<input type="hidden" id="hideCount" value="{{Cart::count()}}">
@empty(Cart::content())
@php $i = 0; @endphp
	@foreach(Cart::content()->reverse() as $shipp)
		<li><a href="#"><i class="fa fa-truck"></i> {{$shipp->name}} <span class='badge badge-qty' >{{$shipp->qty}} X {{$shipp->options->shipp_cost}}</span></a> </li>
		@php $i++; @endphp
	  @if($i == 2) @break @endif
	@endforeach
	<li class="miniCartInfo"><a href="{{route('site.cart.index')}}"><i class="fa fa-truck"></i> {{__('front.miniCart.seeAll')}}</a></li>
@else
	<li class="miniCartInfo"><a href="#"><i class="fa fa-truck"></i> {{__('front.miniCart.empty')}}</a></li>
@endempty
