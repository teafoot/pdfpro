<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>
                    <input type="file" ref="pdfInput" @change="previewFile" accept="application/pdf" />
                    <button @click="uploadPdf">Upload PDF</button>
                    <div v-if="message">{{ message }}</div>
                </div><br/>
                <div>
                    <h2>Your PDF Uploads</h2>
                    <table>
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>Original Filename</th>
                            <th>Status</th>
                            <th>Uploaded At</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="upload in uploads" :key="upload.id">
                                <td>{{ upload.id }}</td>
                                <td>{{ upload.original_filename }}</td>
                                <td>{{ upload.status }}</td>
                                <td>{{ upload.created_at }}</td>
                                <td>
                                    <button @click="viewPdf(upload)">View</button>
                                    <button @click="splitPdf(upload)">Split</button>
                                    <button @click="downloadPdf(upload)">Download</button>
                                    <button @click="deletePdf(upload)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
  data() {
    return {
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      uploads: [],
      error: null,
      selectedFile: null,
      message: ''
    };
  },
  created() {
    this.fetchUploads();
  },
  methods: {
    fetchUploads() {
      fetch('/user/uploads', {
        headers: {
          'Accept': 'application/json',
        //   'Authorization': 'Bearer ' + this.$store.state.user.api_token, // Replace with your method of sending the auth token
        },
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
      })
      .then(data => {
        this.uploads = data;
      })
      .catch(error => {
        this.message = 'There was an error fetching the uploads: ' + error.message;
      });
    },

    previewFile(event) {
      this.selectedFile = event.target.files[0];
    },
    uploadPdf() {
        if (!this.selectedFile) {
            this.message = 'Please select a file before uploading.';
            return;
        }

      const formData = new FormData();
      formData.append('uploadedFile', this.selectedFile);

      fetch('/user/uploads', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': this.csrf
        },
        body: formData,
      })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            this.uploads.push(data);
            this.message = 'PDF uploaded successfully!';
            this.$refs.pdfInput.value = '';
            this.fetchUploads();
        })
        .catch(error => {
            this.message = 'There was an error uploading the file: ' + error.message;
        });
    },
    splitPdf(upload) {
      const formData = new FormData();
      formData.append('pdf_upload_id', upload.id);

      fetch('/user/uploads/split', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': this.csrf
        },
        body: formData,
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
      })
        .then(data => {
            this.message = data.message;
            this.fetchUploads();
        })
        .catch(error => {
            this.message = 'There was an error splitting the file: ' + error.message;
        });
    },

    viewPdf(upload) {
      // Open the PDF in a new tab
      window.open(upload.file_path, '_blank');
    },
    // downloadPdf(upload) {
    //   // Call a backend endpoint to download the PDF
    //   fetch(`/user/uploads/${upload.id}/download`, {
    //     method: 'GET',
    //     headers: {
    //       'Accept': 'application/json',
    //       // 'Authorization': 'Bearer ' + this.$store.state.user.api_token,
    //     },
    //   })
    //   .then(response => response.blob())
    //   .then(blob => {
    //     // Create a link element, use it to download the file and remove it
    //     const url = window.URL.createObjectURL(blob);
    //     const a = document.createElement('a');
    //     a.style.display = 'none';
    //     a.href = url;
    //     a.download = upload.original_filename;
    //     document.body.appendChild(a);
    //     a.click();
    //     window.URL.revokeObjectURL(url);
    //     document.body.removeChild(a);
    //   })
    //   .catch(error => {
    //     this.error = 'There was an error downloading the file: ' + error.message;
    //   });
    // },
    // deletePdf(upload) {
    //   // Call a backend endpoint to delete the PDF
    //   if (confirm('Are you sure you want to delete this PDF?')) {
    //     fetch(`/user/uploads/${upload.id}`, {
    //       method: 'DELETE',
    //       headers: {
    //         'Accept': 'application/json',
    //         // 'Authorization': 'Bearer ' + this.$store.state.user.api_token,
    //       },
    //     })
    //     .then(response => {
    //       if (!response.ok) {
    //         throw new Error('Network response was not ok ' + response.statusText);
    //       }
    //       // Remove the upload from the local state
    //       this.uploads = this.uploads.filter(u => u.id !== upload.id);
    //     })
    //     .catch(error => {
    //       this.error = 'There was an error deleting the upload: ' + error.message;
    //     });
    //   }
    // },
  },
};
</script>