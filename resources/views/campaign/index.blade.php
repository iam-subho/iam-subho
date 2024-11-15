@extends('layout.main')

@section('title',"Campaign Statistics")

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center mb-6">Campaign Statistics</h1>

        <!-- Table to display campaign stats -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Campaign ID</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">utm campaign</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Total Revenue</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $total_rev = 0 ;
                @endphp
                @foreach($allCampaignStat as $stat)
                    @php
                        $total_rev += $stat->total_revenue;
                    @endphp
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 text-sm text-gray-600" title="View Details">
                            <a href="{{ route('campaign', ['campaign' => $stat->campaign]) }}">
                                {{ $stat->campaign_id }}
                            </a>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600">
                            @if($stat->campaign)
                                {{ $stat->campaign->utm_campaign }}
                            @else
                                <span class="text-gray-400">No Campaign</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600">$ {{ $stat->total_revenue }}</td>
                    </tr>
                @endforeach
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

        <!-- Pagination Controls -->
        <div class="mt-6 flex justify-center">
            {{ $allCampaignStat->links() }} <!-- Tailwind pagination links -->
        </div>
    </div>
@endsection
