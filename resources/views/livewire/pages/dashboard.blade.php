<?php

use Livewire\Volt\Component;
use App\Models\MpBook;
use Illuminate\Support\Facades\Log;
use WireUi\Traits\WireUiActions;
use App\Exports\BookingExport;

new class extends Component {
    use WireUiActions;

    public $start_date = '';
    public $end_date = '';
    public $bookings = [];
    public $exportData = [];

    public function clear()
    {
        $this->reset(['start_date', 'end_date', 'bookings', 'exportData']);
    }

    public function downloadReport()
    {
        sleep(2);
        return \Excel::download(new BookingExport($this->exportData), 'bookings_report.xlsx');
    }

    public function generateReport(): void
    {
        if ($this->start_date && $this->end_date) {
            $this->bookings = MpBook::whereBetween('created_on', [$this->start_date, $this->end_date])
                ->with('product.supplier', 'airport')
                ->get()
                ->toArray();

            $this->exportData = [];

            foreach ($this->bookings as $booking) {
                $this->exportData[] = [
                    'Product Name' => $booking['product']['name'] ?? 'N/A',
                    'Airport Name' => $booking['airport']['name'] ?? 'N/A',
                    'Supplier Name' => $booking['product']['supplier']['name'] ?? 'N/A',
                    'Commission' => $booking['commision'] ?? 0,
                    'CC Fee' => $booking['ccfee'] ?? 0,
                    'Net Total' => $booking['net_total'] ?? 0,
                ];
            }
        } else {
            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Something went wrong!',
                'description' => 'Start date and end date is required',
            ]);
        }
    }
}; ?>

<div class="py-12" x-init="initFlowbite();">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg min-h-[80vh]">
            <div class="p-6 text-gray-900 flex items-end justify-center max-w-4xl mx-auto gap-5">
                <x-wui-datetime-picker wire:model.live="start_date" without-time label="Start Date"
                    placeholder="Start Date" />
                <x-wui-datetime-picker wire:model.live="end_date" without-time label="End Date" placeholder="End Date" />
                <x-wui-button primary spinner="generateReport" label="Search" wire:click="generateReport" />
                @if (count($this->bookings) > 0)
                    <x-wui-button primary spinner="downloadReport" label="Download" wire:click="downloadReport" />
                @endif
                <x-wui-button secondary spinner="clear" label="Clear" wire:click="clear" />
            </div>
            @if (count($this->bookings) > 0)
                <div class="max-w-5xl mx-auto my-8" wire:transition>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Product name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Airport Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Supplier Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Commission
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        CC Fee
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Net Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->bookings as $booking)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $booking['product']['name'] }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $booking['airport']['name'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $booking['product']['supplier']['name'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $booking['commision'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $booking['ccfee'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $booking['net_total'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
