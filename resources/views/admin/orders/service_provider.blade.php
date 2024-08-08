@if (in_array('assign_service_provider', $permissionsTitle))
    <form action="{{ route('order.assign_to_service_provider') }}" method="POST">
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        @method('PUT')
        @csrf
        <select class="form-control select2" id="service_provider_id" name="service_provider_id" required>
            <option value=""> {{ __('admin_message.Choose a  Service Provider') }}</option>
            @foreach ($service_providers as $service_provider)
                @if ($service_provider->serviceProvider->id == 568)
                    @if (!empty($order->address))
                        @if (!empty($order->address->city) && !empty($order->recevedCity))
                            <?php
                            $isReceivedCityValid = $AymakanCities->contains($order->receivedCity->title);
                            $isSenderCityValid = $AymakanCities->contains($order->address->city->title);
                            
                            ?>
                            @if ($isSenderCityValid && $isReceivedCityValid && $order->address->phone != null)
                                <option value="{{ $service_provider->serviceProvider->id }}">
                                    {{ $service_provider->serviceProvider->name }}</option>
                            @endif
                        @endif
                    @endif
                @elseif($service_provider->serviceProvider->id == 908)
                <!-- <option value="{{ $service_provider->serviceProvider->id }}">
                {{ $service_provider->serviceProvider->name }}</option> -->
                    @if (!empty($order->address))
                          
                        @if (!empty($order->address->city) && !empty($order->recevedCity))
                        
                            <?php
                            $sender_city = \App\Models\Smb_city::where('title', $order->address->city->title)->first();
                            $recive_city = \App\Models\Smb_city::where('title', $order->recevedCity->title)->first();
                            
                            ?>
                            @if ($sender_city != null && $recive_city != null && $order->address->phone != null)
                                <option value="{{ $service_provider->serviceProvider->id }}">
                                    {{ $service_provider->serviceProvider->name }}</option>
                            @endif
                        @endif
                    @endif
                @else
                    <option value="{{ $service_provider->serviceProvider->id }}">
                        {{ $service_provider->serviceProvider->name }}</option>
                @endif
            @endforeach
        </select>
        <br>
        <input type="submit" class="btn btn-success" value="{{ __('admin_message.Assign To Service Provider') }}">

    </form>
@endif
