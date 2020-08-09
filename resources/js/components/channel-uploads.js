Vue.component('channel-uploads', {

    props: {
        channel: {
            type: Object,
            required: true,
            default: () => ({})
        }
    },

    data: () => ({
        selected: false,
        videos: [],
        progress: {}
    }),

    methods: {
        upload() {
            this.selected = true;
            this.videos = Array.from(this.$refs.videos.files);

            const uploaders = this.videos.map(video => {
                const form = new FormData;
                const self = this;
                self.progress[video.name] = 0;

                form.append('video', video);
                form.append('title', video.name);
                return axios.post(`${appUrl}/channels/${this.channel.id}/videos`, form, {
                    onUploadProgress(event) {
                        self.progress[video.name] = Math.ceil((event.loaded / event.total) * 100);
                        self.$forceUpdate()
                    }
                });
            });
        }
    }
});
