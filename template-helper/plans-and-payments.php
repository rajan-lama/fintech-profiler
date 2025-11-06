<!-- Plans & Payment Tab Content (Active by default) -->
<div class="finx-tab-content active" id="plans-payment-tab">
  <div class="finx-payment-container">
    <!-- LEFT PANEL -->
    <div class="finx-payment-left">
      <i class="fas fa-arrow-left finx-arrow-back"></i>
      <div class="finx-user-box">
        <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/Frame-1707480128.png" alt="Company Logo" class="finx-user-logo">
        <div>
          <div class="company-name">My Awesome Company</div>
          <div class="finx-user-emaill">myawesomecompany@gmail.com</div>
        </div>
      </div>
      <div class="finx-plan-card mb-4">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <p class="finx-plan-subtitle mb-1">UPGRADING TO</p>
            <h4 class="finx-plan-title mb-0">Professional Plan</h4>
          </div>
          <div class="text-end">
            <h4 class="finx-plan-price mb-0">$99</h4>
            <small class="text-muted">Billed Yearly</small>
          </div>
        </div>
        <div class="d-flex justify-content-between mt-3">
          <a href="#" class="finx-plan-link">Switch Plans</a>
          <a href="#" class="finx-plan-link">Switch to Monthly</a>
        </div>
      </div>
      <div class="finx-benefits mb-4">
        <h6>Benefits you'll be getting:</h6>
        <ul>
          <li>Premium reports and content access</li>
          <li>Basic engagement data</li>
          <li>Basic email support</li>
        </ul>
      </div>
      <form class="finx-form">
        <h6 class="mb-3">Payment Details</h6>
        <div class="mb-3">
          <label>Name on card</label>
          <input type="text" class="form-control" placeholder="John Smith">
        </div>
        <div class="mb-3">
          <label>Card number</label>
          <input type="text" class="form-control" placeholder="1234-1234-1234-1234">
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Expiration date</label>
            <input type="text" class="form-control" placeholder="MM/YY">
          </div>
          <div class="col-md-6 mb-3">
            <label>CVV</label>
            <input type="text" class="form-control" placeholder="123">
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Country</label>
            <select class="form-select">
              <option>Startup</option>
              <option>United States</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label>City</label>
            <select class="form-select">
              <option>Startup</option>
              <option>Alabama</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>State (opt)</label>
            <input type="text" class="form-control" placeholder="Alabama">
          </div>
          <div class="col-md-6 mb-3">
            <label>ZIP Code</label>
            <input type="text" class="form-control" placeholder="12345">
          </div>
        </div>
        <div class="mb-3">
          <label>Address</label>
          <input type="text" class="form-control" placeholder="myawesomecompany.com">
        </div>
        <div class="finx-save-info">
          <label class="switch">
            <input type="checkbox" id="saveInfo">
            <span class="slider"></span>
          </label>
          <span class="switch-text">Save this information for future payments</span>
        </div>
      </form>
    </div>
    <!-- RIGHT PANEL (Only for Payment tab) -->
    <div class="finx-payment-right">
      <div class="finx-order-summary">
        <h5>Order Details</h5>
        <div class="finx-order-item">
          <span>Professional Plan</span>
          <span>$89/mo</span>
        </div>
        <div class="finx-total d-flex justify-content-between">
          <span>Total Due</span>
          <span>$89/mo</span>
        </div>
        <p class="text-muted small mt-2">
          You will be billed every month starting 19th Feb 2025 until cancellation.
        </p>
      </div>
      <button class="finx-confirm-btn btn">Confirm Payment</button>
    </div>
  </div>
</div>