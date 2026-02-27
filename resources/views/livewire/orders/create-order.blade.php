@php($customers = $customers ?? \App\Models\Customer::all(['id', 'name']))
@php($users = $users ?? \App\Models\User::all(['id', 'name']))

<div class="modal modal-blur fade" id="modal-create-order" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="order-create-form" action="{{ route('orders.store') }}" method="POST" data-redirect-url="{{ route('orders.index') }}">
                @csrf
                <div class="modal-body">
                    <div id="order-form-errors" class="alert alert-danger d-none"></div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label required">Order Date</label>
                            <input type="datetime-local" class="form-control" id="order-date" value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">External Order No</label>
                            <input type="text" class="form-control" id="order-external-no">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Tracking ID</label>
                            <input type="text" class="form-control" id="order-tracking-id">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label required">Customer</label>
                            <div class="input-group">
                                <select class="form-select" id="order-customer">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal-create-customer">+</button>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Sales Rep.</label>
                            <select class="form-select" id="order-sales-rep">
                                <option value="">Select Sales Rep.</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label class="form-label">Discount(%)</label>
                            <input type="number" class="form-control" id="order-discount-percentage" value="0" min="0">
                        </div>
                    </div>

                    <div class="mb-3 position-relative">
                        <div class="input-group">
                            <input type="text" class="form-control" id="order-product-search" placeholder="Type to Search Product" data-search-url="{{ route('products.search') }}">
                            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal-create-product">+</button>
                        </div>
                        <div class="list-group position-absolute w-100 d-none" id="order-search-results" style="z-index: 2000; top: calc(100% + 4px); max-height: 240px; overflow-y: auto; background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.12);"></div>
                    </div>

                    <div class="table-responsive mb-3">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Discount(%)</th>
                                    <th>Discount</th>
                                    <th>Sales Price</th>
                                    <th>Tax</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="order-products-body">
                                <tr>
                                    <td colspan="10" class="text-center">No products added</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total Quantity</label>
                                <input type="text" class="form-control" id="order-total-qty" value="0" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-end"><strong>Gross Total</strong></td>
                                        <td class="text-end">PKR <span id="order-gross-total">0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-end"><strong>Shipping Charges</strong> (Autofill)</td>
                                        <td class="text-end"><input type="number" class="form-control form-control-sm d-inline-block" style="width: 100px;" id="order-shipping-charges" value="0" min="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-end"><strong>Total Discount</strong></td>
                                        <td class="text-end">PKR <span id="order-total-discount">0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-end"><strong>Tax</strong></td>
                                        <td class="text-end"><input type="number" class="form-control form-control-sm d-inline-block" style="width: 100px;" id="order-tax" value="0" min="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-end"><strong>Net Total</strong></td>
                                        <td class="text-end">PKR <span id="order-net-total">0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-end"><strong>Paid Amount</strong></td>
                                        <td class="text-end"><input type="number" class="form-control form-control-sm d-inline-block" style="width: 100px;" id="order-paid-amount" value="0" min="0"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mb-3">
                        <a href="#" class="text-success small" id="order-autofill">Autofill</a>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Payments</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Attachments</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="order-payments-body"></tbody>
                        </table>
                        <button class="btn btn-outline-secondary w-100 btn-sm" type="button" id="order-add-payment-line" disabled>+ Add New Line</button>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Customer Notes:</label>
                                <textarea class="form-control" rows="3" placeholder="Enter User Comments" id="order-customer-notes"></textarea>
                                <div class="text-end small text-muted">0/500</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Shipping Method</label>
                                <select class="form-select" id="order-shipping-method">
                                    <option value="">Select</option>
                                    <option value="standard">Standard</option>
                                    <option value="express">Express</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select" id="order-payment-method">
                                    <option value="cash">Cash</option>
                                    <option value="bank">Bank Transfer</option>
                                    <option value="card">Card</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success ms-auto" id="order-submit-button">Punch and Deliver</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('page-scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const orderForm = document.getElementById('order-create-form');
        const orderErrors = document.getElementById('order-form-errors');
        const orderSubmit = document.getElementById('order-submit-button');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const searchInput = document.getElementById('order-product-search');
        const searchResults = document.getElementById('order-search-results');
        const productsBody = document.getElementById('order-products-body');

        const totalQtyInput = document.getElementById('order-total-qty');
        const grossTotalEl = document.getElementById('order-gross-total');
        const totalDiscountEl = document.getElementById('order-total-discount');
        const netTotalEl = document.getElementById('order-net-total');
        const discountPercentageInput = document.getElementById('order-discount-percentage');
        const shippingChargesInput = document.getElementById('order-shipping-charges');
        const taxInput = document.getElementById('order-tax');
        const paidAmountInput = document.getElementById('order-paid-amount');

        const customerSelect = document.getElementById('order-customer');
        const orderDateInput = document.getElementById('order-date');
        const externalOrderInput = document.getElementById('order-external-no');
        const trackingInput = document.getElementById('order-tracking-id');
        const salesRepSelect = document.getElementById('order-sales-rep');
        const customerNotesInput = document.getElementById('order-customer-notes');
        const shippingMethodSelect = document.getElementById('order-shipping-method');
        const paymentMethodSelect = document.getElementById('order-payment-method');
        const autofillButton = document.getElementById('order-autofill');
        const paymentsBody = document.getElementById('order-payments-body');
        const addPaymentLineButton = document.getElementById('order-add-payment-line');

        let orderProducts = [];
        let searchTimeout;

        const formatNumber = (value) => Number(value || 0).toFixed(2);

        const showErrors = (errors) => {
            orderErrors.innerHTML = Object.values(errors || {}).flat().map((msg) => `<div>${msg}</div>`).join('');
            orderErrors.classList.remove('d-none');
        };

        const clearErrors = () => {
            orderErrors.classList.add('d-none');
            orderErrors.innerHTML = '';
        };

        const calculateTotals = () => {
            let grossTotal = 0;
            let lineDiscounts = 0;
            let totalQty = 0;

            orderProducts = orderProducts.map((product) => {
                const qty = Number(product.quantity || 0);
                const price = Number(product.unit_price || 0);
                const discountPercent = Number(product.discount_percent || 0);
                const lineTotal = price * qty;
                const discountAmount = lineTotal * (discountPercent / 100);
                const salesPrice = qty ? (lineTotal - discountAmount) / qty : price;
                const subTotal = lineTotal - discountAmount;

                grossTotal += lineTotal;
                lineDiscounts += discountAmount;
                totalQty += qty;

                return {
                    ...product,
                    discount: discountAmount,
                    sales_price: salesPrice,
                    sub_total: subTotal,
                };
            });

            const globalDiscount = grossTotal * (Number(discountPercentageInput?.value || 0) / 100);
            const totalDiscount = lineDiscounts + globalDiscount;
            const netTotal = grossTotal - totalDiscount + Number(taxInput?.value || 0) + Number(shippingChargesInput?.value || 0);

            if (totalQtyInput) totalQtyInput.value = totalQty;
            if (grossTotalEl) grossTotalEl.textContent = formatNumber(grossTotal);
            if (totalDiscountEl) totalDiscountEl.textContent = formatNumber(totalDiscount);
            if (netTotalEl) netTotalEl.textContent = formatNumber(netTotal);
        };

        const createPaymentRow = (amountValue = '') => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <select class="form-select">
                        <option value="">Please Select Account</option>
                    </select>
                </td>
                <td>
                    <select class="form-select">
                        <option value="cash">Cash</option>
                        <option value="cheque">Cheque</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="card">Card</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" min="0" value="${amountValue}">
                </td>
                <td>
                    <input type="datetime-local" class="form-control">
                </td>
                <td>
                    <input type="file" class="form-control">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-icon btn-sm order-payment-remove">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                    </button>
                </td>
            `;
            row.querySelector('.order-payment-remove')?.addEventListener('click', () => {
                row.remove();
                if (paymentsBody && paymentsBody.children.length === 0) {
                    addPaymentLineButton.disabled = true;
                }
            });
            return row;
        };

        const syncPaymentsAvailability = () => {
            if (!paymentsBody || !paidAmountInput || !addPaymentLineButton) return;
            const paidValue = Number(paidAmountInput.value || 0);
            const hasPaid = paidValue > 0;
            addPaymentLineButton.disabled = !hasPaid;

            if (!hasPaid) {
                paymentsBody.innerHTML = '';
                return;
            }

            if (paymentsBody.children.length === 0) {
                paymentsBody.appendChild(createPaymentRow(formatNumber(paidValue)));
            }
        };

        const renderProducts = () => {
            if (!productsBody) return;
            productsBody.innerHTML = '';

            if (orderProducts.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="10" class="text-center">No products added</td>';
                productsBody.appendChild(row);
                calculateTotals();
                return;
            }

            orderProducts.forEach((product, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.sku}</td>
                    <td>${product.name}</td>
                    <td><input type="number" class="form-control form-control-sm order-qty" data-index="${index}" value="${product.quantity}" min="1" style="width: 80px;"></td>
                    <td>${formatNumber(product.unit_price)}</td>
                    <td><input type="number" class="form-control form-control-sm order-discount" data-index="${index}" value="${product.discount_percent}" min="0" style="width: 80px;"></td>
                    <td>${formatNumber(product.discount)}</td>
                    <td>${formatNumber(product.sales_price)}</td>
                    <td>${formatNumber(product.tax || 0)}</td>
                    <td>${formatNumber(product.sub_total)}</td>
                    <td><button type="button" class="btn btn-link text-danger p-0 order-remove" data-index="${index}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                    </button></td>
                `;
                productsBody.appendChild(row);
            });

            productsBody.querySelectorAll('.order-qty').forEach((input) => {
                input.addEventListener('input', (event) => {
                    const index = Number(event.target.dataset.index);
                    orderProducts[index].quantity = Number(event.target.value || 1);
                    calculateTotals();
                    renderProducts();
                });
            });

            productsBody.querySelectorAll('.order-discount').forEach((input) => {
                input.addEventListener('input', (event) => {
                    const index = Number(event.target.dataset.index);
                    orderProducts[index].discount_percent = Number(event.target.value || 0);
                    calculateTotals();
                    renderProducts();
                });
            });

            productsBody.querySelectorAll('.order-remove').forEach((button) => {
                button.addEventListener('click', (event) => {
                    const index = Number(event.currentTarget.dataset.index);
                    orderProducts.splice(index, 1);
                    renderProducts();
                });
            });

            calculateTotals();
        };

        const addProduct = (product) => {
            const existing = orderProducts.find((item) => item.id === product.id);
            if (existing) {
                existing.quantity += 1;
            } else {
                orderProducts.push({
                    id: product.id,
                    sku: product.code || product.sku || product.id,
                    name: product.name,
                    quantity: 1,
                    unit_price: Number(product.selling_price || 0),
                    discount_percent: 0,
                    discount: 0,
                    sales_price: Number(product.selling_price || 0),
                    tax: 0,
                    sub_total: Number(product.selling_price || 0),
                });
            }
            renderProducts();
        };

        if (searchInput && searchResults) {
            searchInput.addEventListener('input', () => {
                const term = searchInput.value.trim();
                if (searchTimeout) clearTimeout(searchTimeout);
                if (term.length < 2) {
                    searchResults.classList.add('d-none');
                    searchResults.innerHTML = '';
                    return;
                }

                searchTimeout = setTimeout(async () => {
                    const url = searchInput.dataset.searchUrl;
                    if (!url) return;
                    const response = await fetch(`${url}?search=${encodeURIComponent(term)}`, {
                        headers: { 'Accept': 'application/json' },
                    });
                    if (!response.ok) return;
                    const data = await response.json();
                    const products = data.products || [];
                    searchResults.innerHTML = '';
                    products.forEach((product) => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = `${product.name} (${product.code})`;
                        item.addEventListener('click', () => {
                            addProduct(product);
                            searchInput.value = '';
                            searchResults.classList.add('d-none');
                            searchResults.innerHTML = '';
                        });
                        searchResults.appendChild(item);
                    });
                    searchResults.classList.toggle('d-none', products.length === 0);
                }, 300);
            });
        }

        if (discountPercentageInput) discountPercentageInput.addEventListener('input', calculateTotals);
        if (shippingChargesInput) shippingChargesInput.addEventListener('input', calculateTotals);
        if (taxInput) taxInput.addEventListener('input', calculateTotals);
        if (paidAmountInput) paidAmountInput.addEventListener('input', syncPaymentsAvailability);

        if (addPaymentLineButton) {
            addPaymentLineButton.addEventListener('click', () => {
                if (!paymentsBody || !paidAmountInput) return;
                const paidValue = Number(paidAmountInput.value || 0);
                if (paidValue <= 0) {
                    addPaymentLineButton.disabled = true;
                    return;
                }
                paymentsBody.appendChild(createPaymentRow(''));
            });
        }

        if (autofillButton) {
            autofillButton.addEventListener('click', (event) => {
                event.preventDefault();
                paidAmountInput.value = netTotalEl?.textContent || '0';
                syncPaymentsAvailability();
            });
        }

        document.addEventListener('customer-created', (event) => {
            const customer = event.detail?.customer;
            if (!customer || !customerSelect) return;
            const option = document.createElement('option');
            option.value = customer.id;
            option.textContent = customer.name;
            customerSelect.appendChild(option);
            customerSelect.value = customer.id;
        });

        document.addEventListener('product-created', (event) => {
            const product = event.detail?.product;
            if (product) {
                addProduct({
                    id: product.id,
                    name: product.name,
                    code: product.code,
                    selling_price: product.selling_price || 0,
                });
            }
        });

        syncPaymentsAvailability();

        if (orderForm) {
            orderForm.addEventListener('submit', async (event) => {
                event.preventDefault();
                clearErrors();
                orderSubmit.disabled = true;

                if (orderProducts.length === 0) {
                    showErrors({ items: ['Please add at least one product.'] });
                    orderSubmit.disabled = false;
                    return;
                }

                const payload = {
                    order_date: orderDateInput?.value || null,
                    external_order_no: externalOrderInput?.value || null,
                    tracking_id: trackingInput?.value || null,
                    customer_id: customerSelect?.value || null,
                    sales_rep_id: salesRepSelect?.value || null,
                    discount_percentage: Number(discountPercentageInput?.value || 0),
                    shipping_charges: Number(shippingChargesInput?.value || 0),
                    tax: Number(taxInput?.value || 0),
                    payment_type: paymentMethodSelect?.value || 'cash',
                    pay: Number(paidAmountInput?.value || 0),
                    customer_notes: customerNotesInput?.value || null,
                    shipping_method: shippingMethodSelect?.value || null,
                    items: orderProducts.map((product) => ({
                        product_id: product.id,
                        quantity: product.quantity,
                        unit_price: product.unit_price,
                        discount_percent: product.discount_percent,
                        sub_total: product.sub_total,
                    })),
                };

                try {
                    const response = await fetch(orderForm.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                        },
                        body: JSON.stringify(payload),
                    });

                    if (response.status === 422) {
                        const data = await response.json().catch(() => ({}));
                        showErrors(data.errors || { error: ['Unable to save order.'] });
                        return;
                    }

                    if (!response.ok) {
                        showErrors({ error: ['Unable to save order.'] });
                        return;
                    }

                    const data = await response.json().catch(() => ({}));
                    if (data.success) {
                        const redirectUrl = orderForm.dataset.redirectUrl;
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        } else {
                            window.location.reload();
                        }
                    }
                } catch (error) {
                    showErrors({ error: ['Unable to save order.'] });
                } finally {
                    orderSubmit.disabled = false;
                }
            });
        }
    });
</script>
@endpush
