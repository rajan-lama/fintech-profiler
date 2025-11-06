<!-- General Info Tab Content -->
<div class="finx-tab-content" id="general-info-tab">
  <div class="finx-full-content">
    <div class="finx-full-content container py-4">
      <h2 class="fw-semibold mb-1">Basic Information</h2>
      <p class="text-muted mb-4">The most basic required information needed to qualify for listing</p>
      <!-- Company Profile Picture Section -->
      <div class="row align-items-center mb-4">
        <div class="col-md-6">
          <h5 class="fw-semibold mb-3">Company Profile Picture</h5>
        </div>
        <div class="col-md-6 d-flex align-items-center">
          <!-- Image Preview (hidden by default) -->
          <div class="me-3">
            <img id="companyImagePreview"
              src=""
              alt="Company Logo Preview"
              class="border rounded d-none"
              style="width: 80px; height: 80px; object-fit: cover;">
          </div>
          <!-- Upload Controls -->
          <div>
            <input type="file" id="companyImageInput" accept=".jpg,.png,.svg,.zip" class="d-none">
            <button type="button" id="uploadButton" class="btn btn-light border">Upload Image</button>
            <p class="text-muted small mb-0">Supports .jpg, .png, .svg and .zip files</p>
          </div>
        </div>
      </div>
      <hr class="my-4">

      <!-- CONTACT INFO SECTION -->
      <div class="row align-items-start mb-4">
        <div class="col-md-6">
          <h5 class="fw-semibold mb-3">Basic Information</h5>
        </div>
        <div class="col-md-6">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Company Name</label>
              <input type="text" class="form-control" placeholder="My awesome Company">
            </div>
            <div class="col-12">
              <label class="form-label">Website Link</label>
              <input type="text" class="form-control" placeholder="myawesomecompany.com">
            </div>
            <div class="col-md-6">
              <label class="form-label">Founded In</label>
              <input type="text" class="form-control" placeholder="Year">
            </div>
            <div class="col-md-6">
              <label class="form-label">Company Size</label>
              <select class="form-select">
                <option selected>Start Up</option>
                <option>Option 2</option>
                <option>Option 3</option>
                <option>Option 4</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Slogan (opt)</label>
              <input type="text" class="form-control" placeholder="Enter company slogan">
            </div>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Services Provided Section -->
      <div class="row align-items-start">
        <div class="col-md-6">
          <h5 class="fw-semibold mb-3">Services Provided</h5>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label fw-semibold">What services do you offer?</label>
            <div id="selected-services" class="multi-select-box"></div>
          </div>

          <div class="mb-3">
            <p class="fw-semibold mb-2">Digital Banking</p>
            <div>
              <div><input type="checkbox" class="service-option" value="Online Banking Platforms"> Online Banking Platforms</div>
              <div><input type="checkbox" class="service-option" value="Digital Onboarding Solutions"> Digital Onboarding Solutions</div>
              <div><input type="checkbox" class="service-option" value="Bill Pay Solutions"> Bill Pay Solutions</div>
              <div><input type="checkbox" class="service-option" value="Account Opening Solutions"> Account Opening Solutions</div>
              <div><input type="checkbox" class="service-option" value="Personal Finance Management Tools"> Personal Finance Management Tools</div>
            </div>
          </div>

          <div class="mb-3">
            <p class="fw-semibold mb-2">Regulatory & Compliance</p>
            <div>
              <div><input type="checkbox" class="service-option" value="OFAC Solutions"> OFAC Solutions</div>
              <div><input type="checkbox" class="service-option" value="Anti-Money Laundering"> Anti-Money Laundering</div>
              <div><input type="checkbox" class="service-option" value="Know Your Customer"> Know Your Customer</div>
              <div><input type="checkbox" class="service-option" value="Verification of Payee Solutions"> Verification of Payee Solutions</div>
              <div><input type="checkbox" class="service-option" value="Regulatory Compliance Solutions"> Regulatory Compliance Solutions</div>
              <div><input type="checkbox" class="service-option" value="Risk Assessment and Management Tools"> Risk Assessment and Management Tools</div>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>