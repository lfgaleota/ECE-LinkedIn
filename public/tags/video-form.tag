<video-form>
    <div class="back"></div>
    <form ref="form" class="form-container" onreset={ cancel } onsubmit={ submit }>
        <div>
            <textarea ref="text_content" name="description" class="text-content"></textarea>
            <div class="toolbar">
                <input ref="file" if={ !edit } type="file" name="video" accept="video/avi,video/mpeg,video/quicktime,video/mp4,video/ogg,video/webm" required onchange={ onFileChange } />
                <button class="button float-right" type="submit"><i class="fa fa-check"></i></button>
                <button class="button float-right" type="reset"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="progress" ref="progressBar"></div>
    </form>

    <style>
        :scope {
            width: 0;
            height: 0;
            margin: 0;
        }

        input[type="file"] {
            width: auto;
            margin: 0;
            font-size: 14px;
            padding-top: 1em;
            padding-left: 1em;
        }

        form {
            position: fixed !important;
            display: block !important;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            max-width: 500px;
            width: 100%;
            z-index: 2030;
        }

        .back {
            position: fixed;
            display: block;
            background: rgba( 0, 0, 0, 0.5 );
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 2025;
        }

        .card-section {
            padding: 0;
        }

        .text-content {
            border: 0;
            border-bottom: 1px solid hsla(0,0%,4%,.25);
            margin: 0;
            min-height: 100px;
        }

        .toolbar {
            font-size: 0;
        }

        .toolbar > *,
        .toolbar .button {
            display: inline-block;
            margin: 0;
        }

        .toolbar .button {
            font-size: 16px;
        }

        .progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            width: 0;
            padding: 0;
            margin: 0;
            background: #23a3ba;
            transition: width 0.25s ease-in;
        }
    </style>

    <script>
        this.files = [];
        this.edit = false;
        let that = this;

        setItem( item ) {
            that.clear();
            that.edit = true;
            that.post_id = item.post_id;
            that.refs.text_content.value = item.description;
            that.update();
        }

        this.on( 'mount', function() {
            if( opts.item ) {
                that.setItem( opts.item );
            }
        });

        function getForm() {
            let formData = new FormData();
            formData.append( 'video', that.files[ 0 ], that.files[ 0 ].name );
            formData.append( 'description', that.refs.text_content.value );
            if( that.post_id ) {
                formData.append( 'post_id', that.post_id );
            }
            return formData;
        }

        onFileChange( e ) {
            let files = e.target.files || e.dataTransfer.files;
            that.files = files;
        }

        setProgress( progress ) {
            that.refs.progressBar.style.width = progress + '%';
        }

        clear() {
            that.refs.file.value = "";
            that.refs.text_content.value = "";
        }

        disable() {
            that.refs.file.disabled = true;
            that.refs.text_content.disabled = true;
        }

        enable() {
            that.refs.file.disabled = false;
            that.refs.text_content.disabled = false;
        }

        submit(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let form = getForm();
            if( opts.onSelected ) {
                opts.onSelected( form, that );
            }
        }

        cancel(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            this.unmount();
            if( opts.onCancelled ) {
                opts.onCancelled( that );
            }
        }
    </script>
</video-form>