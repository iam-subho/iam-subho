@extends('layout.main')

@section('title', 'Hourly Revenue for Campaign: ' . $campaign->utm_campaign)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-6">Hourly Revenue for Campaign: {{ $campaign->utm_campaign }}</h1>

        <div class="flex justify-center">
            <a href="{{ route('home') }}" class="text-blue-500 hover:none">Home</a>
            &nbsp; &nbsp;&nbsp;
            <a href="{{ route('campaign', ['campaign' => $campaign]) }}" class="text-blue-500 hover:none">By hourly campaign</a>
            &nbsp; &nbsp;&nbsp;
            <a href="{{ route('campaign', ['campaign' => $campaign , 'type'=>'utm']) }}" class="text-blue-500 hover:none">By hourly utm_term & campaign</a>
        </div>

        <!-- Table to display hourly revenue data -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Utm Term</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Date and Hour</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Total Revenue</th>
                </tr>
                </thead>
                <tbody>
                @php
                  $total_rev = 0 ;
                @endphp
                @forelse($hourlyRevenue as $stat)
                    @php
                      $total_rev += $stat->total_revenue;
                    @endphp
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $stat->utmTerm->utm_term }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $stat->hour }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">$ {{ number_format($stat->total_revenue, config('app.decimel_digit')) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-4 py-2 text-sm text-gray-600 text-center">No revenue data available for this campaign.</td>
                    </tr>
                @endforelse
                   <tr>
                       <td colspan="2">Sub Total Revenue</td>
                       <td class="px-4 py-2 text-sm text-gray-600" >$ {{ number_format($total_rev,config('app.decimel_digit')) }}</td>
                   </tr>
                   <tr>
                       <td colspan="2">Total Revenue</td>
                       <td class="px-4 py-2 text-sm text-gray-600" >$ {{ number_format($totalRevenue,config('app.decimel_digit')) }}</td>
                   </tr>

                </tbody>
            </table>
        </div>

        <!-- Pagination (Optional) -->
        <div class="mt-6 flex justify-center">
            {{ $hourlyRevenue->links() }}
        </div>
    </div>
@endsection
