<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="flex w-1/4 card bg-base-300 rounded-box p-2">
                    <input class="mb-2" type="file" ref="pdfInput" @change="changeUploadFile" accept="application/pdf" />
                    <button class="btn btn-primary" @click="uploadPdf">Upload PDF</button>
                    <span v-if="message">{{ message }}</span>
                </div><br/>
                <div class="flex w-full mb-5">
                    <div class="flex flex-grow card bg-base-300 rounded-box">
                        <h2>Your PDF Uploads</h2>
                        <DataTable :value="uploads" selectionMode="multiple" :paginator="true" :rows="10" dataKey="id" :filters="filters" :globalFilterFields="['original_filename', 'status', 'created_at']">
                            <Column selectionMode="multiple"></Column>
                            <Column field="id" header="ID" sortable></Column>
                            <Column field="original_filename" header="Original Filename" sortable filter filterPlaceholder="Search by name"></Column>
                            <Column field="status" header="Status" sortable filter filterPlaceholder="Search by status"></Column>
                            <Column field="created_at" header="Uploaded At" sortable filter filterPlaceholder="Search by date"></Column>
                            <Column header="Actions">
                                <template #body="slotProps">
                                    <button @click="splitPdf(slotProps.data)" class="pi pi-bolt mr-1"></button>
                                    <i @click="previewPdf(slotProps.data)" class="pi pi-eye"></i>
                                    <i @click="viewPdf(slotProps.data)" class="pi pi-external-link mr-1"></i>
                                    <!--<button @click="deletePdf(slotProps.data)">Delete</button>-->
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
                <div v-if="previewFile" class="flex w-full">
                    <div v-if="previewFile" class="flex flex-grow card bg-base-300 rounded-box place-items-center">
                        <iframe :src="previewFile" width="100%" height="600px"></iframe>
                    </div>
                    <div class="divider divider-horizontal"></div>
                    <div class="flex flex-grow card bg-base-300 rounded-box">
                        <textarea v-model="chatContent" class="textarea textarea-bordered textarea-lg w-full h-full mb-2" ></textarea>
                        <div class="flex items-center space-x-2">
                            <textarea @keydown="handleInputKeydown" type="text" id="chat" ref="chatInput" placeholder="PDF Chat" class="input input-bordered w-full"></textarea>
                            <button @click="sendChatMessage" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { baseFetch } from '@/http';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
// import ColumnGroup from 'primevue/columngroup';   // optional
// import Row from 'primevue/row';                   // optional

export default {
  components: {
    DataTable,
    Column
  },
  data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      uploads: [],
      error: null,
      uploadingFile: null,
      previewFile: null,
      message: '',
      chatContent: ''
    };
  },
  created() {
    this.fetchUploads();
  },
  methods: {
    fetchUploads() {
      baseFetch('/api/user/uploads')
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
    changeUploadFile(event) {
      this.uploadingFile = event.target.files[0];
    },
    uploadPdf() {
        if (!this.uploadingFile) {
            this.message = 'Please select a file before uploading.';
            return;
        }

      const formData = new FormData();
      formData.append('uploadedFile', this.uploadingFile);

      baseFetch('/api/user/uploads', {
        method: 'POST',
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

      baseFetch('/api/user/uploads/split', {
        method: 'POST',
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
    previewPdf(upload) {
        const baseUrl = window.location.origin;
        const pdfFullPath = `${baseUrl}/storage/${upload.file_path}`;
        this.previewFile = pdfFullPath;
    },
    viewPdf(upload) {
        const baseUrl = window.location.origin;
        const pdfFullPath = `${baseUrl}/storage/${upload.file_path}`;
        window.open(pdfFullPath, '_blank');
    },
    handleInputKeydown(event) {
      if (event.key === 'Enter' && !event.shiftKey) {
        // If Enter is pressed without the Shift key, prevent the default
        // textarea behavior of inserting a new line and send the message.
        event.preventDefault();
        this.sendChatMessage();
      }
      // If Shift+Enter is pressed, the default behavior will insert a new line.
    },
    sendChatMessage() {
      const chatInput = this.$refs.chatInput;
      const message = chatInput.value.trim();
      
      if (message.trim() === '') {
        alert('Please enter a message.');
        return;
      }

      baseFetch('/api/ollama/chat', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ message: message }),
      })
      .then(response => response.json())
      .then(data => {
        if (data && data.message && data.message.content) {
            this.chatContent += '\n' + data.message.content;
        }
        chatInput.value = '';
      })
      .catch(error => {
        console.error('Error:', error);
      });
    },
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