<div class="row">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center">
      @if($isTrusted)
        <span>
          <i class="bi bi-shield-check text-success me-1 fs-2"></i>
          This Device is trusted.
        </span>
        <button type="button" class="btn btn-danger" onclick="trustToggle();">
          <i class="bi bi-x-lg me-1"></i>
          Untrust
        </button>
      @else
        <span>
          <i class="bi bi-shield-exclamation text-danger me-1 fs-2"></i>
          This device is untrust.
        </span>
        <button type="button" class="btn btn-success" onclick="trustToggle();">
          <i class="bi bi-check2-all me-1"></i>
          Trust
        </button>
      @endif
    </div>
  </div>
</div>
<!-- Ringkasan Statistik -->
<div class="row mb-4">
  <div class="col-md-6">
    <div class="summary-box">
      <h6 class="fw-bold text-primary mb-2"><i class="bi bi-info-circle me-2"></i>Ringkasan Aktivitas</h6>
      <p class="mb-0">Total ada <span class="fw-bold">{{ $stats['total_logins'] }} login</span> dalam 30 hari terakhir dengan <span class="fw-bold">{{ $stats['trusted_devices'] }} perangkat terpercaya</span>. Terdeteksi <span class="fw-bold">{{ $stats['suspicious_activities'] }} aktivitas mencurigakan</span>.</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="summary-box">
      <h6 class="fw-bold text-primary mb-2"><i class="bi bi-clock-history me-2"></i>Periode Waktu</h6>
      <p class="mb-0">Semua login dalam 7 hari terakhir juga termasuk dalam 30 hari terakhir. Terdapat <span class="fw-bold">{{ $stats['failed_attempts'] }} upaya gagal</span> dari total percobaan login.</p>
    </div>
  </div>
</div>
                        
<!-- Baris Statistik 1 -->
<div class="row stat-item">
  <div class="col-md-6 mb-3 mb-md-0">
    <div class="d-flex align-items-center">
      <div class="stat-icon primary-bg">
        <i class="bi bi-door-open"></i>
      </div>
      <div>
        <div class="stat-value text-primary">{{ $stats['total_logins'] }}</div>
        <div class="stat-label">Total Login</div>
        <span class="badge-stat bg-primary bg-opacity-10 text-primary">Seluruh waktu</span>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="d-flex align-items-center">
      <div class="stat-icon danger-bg">
        <i class="bi bi-exclamation-triangle"></i>
      </div>
      <div>
        <div class="stat-value text-danger">{{ $stats['failed_attempts'] }}</div>
        <div class="stat-label">Upaya Gagal</div>
        <span class="badge-stat bg-danger bg-opacity-10 text-danger">Perlu diperhatikan</span>
      </div>
    </div>
  </div>
</div>
                        
<!-- Baris Statistik 2 -->
<div class="row stat-item">
  <div class="col-md-6 mb-3 mb-md-0">
    <div class="d-flex align-items-center">
      <div class="stat-icon info-bg">
        <i class="bi bi-phone"></i>
      </div>
      <div>
        <div class="stat-value text-info">{{ $stats['unique_devices'] }}</div>
        <div class="stat-label">Perangkat Unik</div>
        <span class="badge-stat bg-info bg-opacity-10 text-info">Aktif</span>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="d-flex align-items-center">
      <div class="stat-icon info-bg">
        <i class="bi bi-globe"></i>
      </div>
      <div>
        <div class="stat-value text-info">{{ $stats['unique_ips']}}</div>
        <div class="stat-label">IP Unik</div>
        <span class="badge-stat bg-info bg-opacity-10 text-info">Lokasi</span>
      </div>
    </div>
  </div>
</div>
                        
<!-- Baris Statistik 3 -->
<div class="row stat-item">
  <div class="col-md-6 mb-3 mb-md-0">
    <div class="d-flex align-items-center">
      <div class="stat-icon warning-bg">
        <i class="bi bi-calendar-month"></i>
      </div>
      <div>
        <div class="stat-value" style="color: #e6ac00;">{{ $stats['last_30_days'] }}</div>
        <div class="stat-label">30 Hari Terakhir</div>
        <span class="badge-stat bg-warning bg-opacity-10" style="color: #b38600;">Aktivitas terkini</span>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="d-flex align-items-center">
      <div class="stat-icon warning-bg">
        <i class="bi bi-calendar-week"></i>
      </div>
      <div>
        <div class="stat-value" style="color: #e6ac00;">{{ $stats['last_7_days'] }}</div>
        <div class="stat-label">7 Hari Terakhir</div>
        <span class="badge-stat bg-warning bg-opacity-10" style="color: #b38600;">Aktivitas padat</span>
      </div>
    </div>
  </div>
</div>
                        
<!-- Baris Statistik 4 -->
<div class="row">
  <div class="col-md-6 mb-3 mb-md-0">
    <div class="d-flex align-items-center">
      <div class="stat-icon danger-bg">
        <i class="bi bi-shield-exclamation"></i>
      </div>
      <div>
        <div class="stat-value text-danger">{{ $stats['suspicious_activities'] }}</div>
        <div class="stat-label">Aktivitas Mencurigakan</div>
        <span class="badge-stat bg-success bg-opacity-10 text-success">Aman</span>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="d-flex align-items-center">
      <div class="stat-icon success-bg">
        <i class="bi bi-shield-check"></i>
      </div>
      <div>
        <div class="stat-value text-success">{{ $stats['trusted_devices'] }}</div>
        <div class="stat-label">Perangkat Terpercaya</div>
        <span class="badge-stat bg-success bg-opacity-10 text-success">Terverifikasi</span>
      </div>
    </div>
  </div>
</div>
                        
<div class="last-updated mb-2">
  <i class="bi bi-clock me-1"></i> Data diperbarui secara real-time dari sistem log management
</div>
                
<!-- Info tambahan -->
<div class="alert alert-info">
  <div class="d-flex">
    <div class="me-3">
      <i class="bi bi-lightbulb fs-4"></i>
    </div>
    <div>
      <h6 class="alert-heading fw-bold">Interpretasi Data</h6>
      <p class="mb-0">Data menunjukkan bahwa semua login terjadi dalam 7 hari terakhir ({{ $stats['total_logins'] }} login) dengan {{ $stats['failed_attempts'] }} upaya gagal. Ada {{ $stats['unique_ips'] }} alamat IP yang digunakan untuk mengakses dari {{ $stats['unique_devices'] }} perangkat berbeda, dan {{ $stats['trusted_devices'] }} perangkat telah ditandai sebagai terpercaya. Tidak ada aktivitas mencurigakan yang terdeteksi.</p>
    </div>
  </div>
</div>

<script>
  async function trustToggle() {
    @if($isTrusted)
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