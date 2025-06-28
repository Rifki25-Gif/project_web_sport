@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Order Management') }}
    </h2>
@endsection

@section('slot')
    <!-- Development Mode Notice -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong class="font-bold">Development Mode:</strong> All transactions are dummy transactions for testing purposes.
                        No actual payments have been processed.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="py-12" x-data="{ showModal: false, selectedOrder: null, showNotification: false, notificationMessage: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Orders</h3>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <select id="status-filter" class="block appearance-none w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">All Statuses</option>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <table id="orders-table" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dummyOrders = [
                                    ['id' => '#12345', 'customer' => 'John Doe', 'date' => '2024-07-30', 'total' => '$150.00', 'status' => 'Shipped', 'status_class' => 'bg-green-100 text-green-800', 'payment' => 'Dummy', 'payment_class' => 'bg-blue-100 text-blue-800', 'items' => [['name' => 'Running Shoes', 'qty' => 1, 'price' => '$100.00'], ['name' => 'Sports Socks', 'qty' => 2, 'price' => '$25.00']]],
                                    ['id' => '#12346', 'customer' => 'Jane Smith', 'date' => '2024-07-29', 'total' => '$200.00', 'status' => 'Processing', 'status_class' => 'bg-yellow-100 text-yellow-800', 'payment' => 'Dummy', 'payment_class' => 'bg-blue-100 text-blue-800', 'items' => [['name' => 'Basketball', 'qty' => 1, 'price' => '$50.00'], ['name' => 'Jersey', 'qty' => 1, 'price' => '$150.00']]],
                                    ['id' => '#12347', 'customer' => 'Mike Johnson', 'date' => '2024-07-28', 'total' => '$75.50', 'status' => 'Delivered', 'status_class' => 'bg-blue-100 text-blue-800', 'payment' => 'Dummy', 'payment_class' => 'bg-blue-100 text-blue-800', 'items' => [['name' => 'Yoga Mat', 'qty' => 1, 'price' => '$75.50']]],
                                    ['id' => '#12348', 'customer' => 'Emily Williams', 'date' => '2024-07-27', 'total' => '$320.00', 'status' => 'Cancelled', 'status_class' => 'bg-red-100 text-red-800', 'payment' => 'Dummy', 'payment_class' => 'bg-blue-100 text-blue-800', 'items' => []],
                                    ['id' => '#12349', 'customer' => 'Chris Brown', 'date' => '2024-07-26', 'total' => '$50.00', 'status' => 'Pending', 'status_class' => 'bg-gray-100 text-gray-800', 'payment' => 'Dummy', 'payment_class' => 'bg-blue-100 text-blue-800', 'items' => [['name' => 'Dumbbells', 'qty' => 2, 'price' => '$25.00']]],
                                ];
                            @endphp
                            @foreach ($dummyOrders as $order)
                            <tr>
                                <td>{{ $order['id'] }}</td>
                                <td>{{ $order['customer'] }}</td>
                                <td>{{ $order['date'] }}</td>
                                <td>{{ $order['total'] }}</td>
                                <td><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order['status_class'] }}">{{ $order['status'] }}</span></td>
                                <td><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order['payment_class'] }}">{{ $order['payment'] }}</span></td>
                                <td>
                                    <button @click="showModal = true; selectedOrder = {{ json_encode($order) }}" class="text-blue-500 hover:text-blue-700">Details</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Detail Modal -->
        <div x-show="showModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-2xl" @click.away="showModal = false">
                <div id="printableArea">
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200" x-text="'Order Details ' + selectedOrder.id"></h3>
                    
                    <!-- Development Mode Badge -->
                    <div class="mb-4 inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        Development Mode - Dummy Payment
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p><strong>Customer:</strong> <span x-text="selectedOrder.customer"></span></p>
                            <p><strong>Date:</strong> <span x-text="selectedOrder.date"></span></p>
                        </div>
                        <div>
                            <p><strong>Total:</strong> <span x-text="selectedOrder.total"></span></p>
                            <div class="flex items-center">
                                <p class="mr-2"><strong>Status:</strong></p>
                                <select x-model="selectedOrder.status" @change="updateStatus(selectedOrder.id, $event.target.value)" class="block appearance-none bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:border-gray-400 px-2 py-1 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="Pending">Pending</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Delivered">Delivered</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Items</h4>
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left">Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Price</th>
                                </tr>
                            </thead>
                            <tbody x-html="selectedOrder.items.map(item => `<tr><td>${item.name}</td><td class='text-center'>${item.qty}</td><td class='text-right'>${item.price}</td></tr>`).join('')">
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Shipping Tracking (Dummy)</h4>
                        <div class="relative">
                            <div class="border-l-2 border-blue-500 absolute h-full left-2"></div>
                            <div class="mb-4 pl-8">
                                <p class="font-semibold">Order Placed</p>
                                <p class="text-sm text-gray-500">July 26, 2024</p>
                            </div>
                            <div class="mb-4 pl-8">
                                <p class="font-semibold">Processing</p>
                                <p class="text-sm text-gray-500">July 27, 2024</p>
                            </div>
                             <div class="mb-4 pl-8">
                                <p class="font-semibold">Shipped</p>
                                <p class="text-sm text-gray-500">July 28, 2024 - Tracking #123456789</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-4">
                    <button @click="showModal = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Close</button>
                    <button @click="printModal" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Print</button>
                </div>
            </div>
        </div>

        <!-- Notification -->
        <div x-show="showNotification" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            class="fixed bottom-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg"
            style="display: none;">
            <p x-text="notificationMessage"></p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = new DataTable('#orders-table', {
            responsive: true,
        });

        $('#status-filter').on('change', function() {
            table.column(4).search(this.value).draw();
        });
    });

    function printModal() {
        var printableArea = document.getElementById('printableArea').innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printableArea;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload(); // to re-initialize scripts
    }

    function updateStatus(orderId, status) {
        // Here you would typically make an AJAX call to update the status in the database
        console.log(`Updating order ${orderId} to status ${status}`);
        
        this.notificationMessage = `Order ${orderId} status updated to ${status}.`;
        this.showNotification = true;
        setTimeout(() => {
            this.showNotification = false;
        }, 3000);

        // We also need to update the table data. For now, let's just log it.
        // In a real application, you would re-fetch the data or update the table row.
        console.log('Need to update table data');
        
    }
</script>
@endpush 