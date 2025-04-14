<template>
  <div class="card">
    <div class="card-header">
      <h5 class="card-title mb-0">Estado del Worker</h5>
    </div>
    <div class="card-body">
      <div class="d-flex align-items-center">
        <div class="icon-circle" :class="statusClass">
          <i class="fas" :class="statusIcon"></i>
        </div>
        <div class="ms-3">
          <h6 class="mb-1">{{ statusText }}</h6>
          <p class="small text-muted mb-0">Última verificación: {{ lastChecked }}</p>
        </div>
      </div>
      <div class="mt-3">
        <div class="progress" style="height: 5px;">
          <div class="progress-bar" :class="progressClass" role="progressbar" :style="{ width: progressWidth }"></div>
        </div>
        <div class="small text-muted mt-2">
          <span class="me-3">{{ pendingJobs }} trabajos pendientes</span>
          <span class="ms-3">{{ queueSize }} en cola</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      status: null,
      lastChecked: null,
      pendingJobs: 0,
      queueSize: 0,
      interval: null
    };
  },
  computed: {
    statusClass() {
      return this.status ? 'bg-success' : 'bg-danger';
    },
    statusIcon() {
      return this.status ? 'fa-check' : 'fa-exclamation-circle';
    },
    statusText() {
      return this.status ? 'Activo' : 'Inactivo';
    },
    progressClass() {
      return this.status ? 'bg-success' : 'bg-danger';
    },
    progressWidth() {
      return this.status ? '100%' : '0%';
    }
  },
  methods: {
    async checkStatus() {
      try {
        const response = await axios.get(route('worker.status'));
        const data = response.data;
        this.status = data.is_active;
        this.lastChecked = data.last_checked;
        this.pendingJobs = data.pending_jobs;
        this.queueSize = data.queue_size;
      } catch (error) {
        this.status = false;
        this.lastChecked = 'Error de conexión';
        this.pendingJobs = 0;
        this.queueSize = 0;
      }
    },
    startPolling() {
      this.checkStatus();
      this.interval = setInterval(() => {
        this.checkStatus();
      }, 30000); // Actualizar cada 30 segundos
    },
    stopPolling() {
      if (this.interval) {
        clearInterval(this.interval);
      }
    }
  },
  mounted() {
    this.startPolling();
  },
  beforeDestroy() {
    this.stopPolling();
  }
};
</script>
