<div class="row">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center">
      @if($isTrusted)
        <span>
          <i class="bi bi-shield-check text-success me-2 fs-2"></i>
          This Device is trusted.
        </span>
        <button type="button" class="btn btn-danger" onclick="trustToggle();">
          <i class="bi bi-x-lg me-2"></i>
          Untrust this device
        </button>
      @else
        <span>
          <i class="bi bi-shield-exclamation text-danger me-2 fs-2"></i>
          This device is untrust.
        </span>
        <button type="button" class="btn btn-success" onclick="trustToggle();">
          <i class="bi bi-check2-all me-2"></i>
          Trust this device
        </button>
      @endif
    </div>
  </div>
</div>

<script>
  async function trustToggle() {
    @if(!$isTrusted)
    if(!confirm('Are you sure to untrust this device ?')) return;
    @endif
    
    const showAlertExist = typeof window.showAlert === 'function';
    
    try {
      const response = await fetch("{{ secure_url(config('app.url'))}}/log/authlog/trusted-device", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ device_id: '{{ $device }}'})
      });
    
      const data = await response.json();

      if(data.success) {
        if(showAlertExist) {
          showAlert('Success', data.message || 'Operation success', 'success');
        } else {
          alert(data.message);
        }
        
        // Reload page after 1.5 seconds
        setTimeout(() => {
          window.location.reload();
        }, 1500);
      } else {
        if(showAlertExist) {
          showAlert('Error', data.message, 'danger');
        } else {
          alert(data.message)
        }
      }
    } catch(error) {
      console.error(error);
      if(showAlertExist) {
        showAlert('Error', error.message || 'Failed to do this operation.', 'danger');
      } else {
        alert(error.message);
      }
    }
  }
</script>