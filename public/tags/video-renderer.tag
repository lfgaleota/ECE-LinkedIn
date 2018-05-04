<video-renderer>
    <div class="thumbnail">
        <video src={ opts.item.video_url }>
            <div class="callout alert">
                <p><i class="fas fa-exclamation-triangle"></i> Vid"o non  prise en charge par le navigateur.</p>
            </div>
        </video>
    </div>

    <style>
        video {
            width: 128px;
            height: 128px;
            border: 1px solid black;
        }

        .thumbnail {
            margin: 0;
        }
    </style>
</video-renderer>