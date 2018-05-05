<entity-renderer>
    <div class="grid-x grid-padding-x">
        <div class="cell shrink">
            <img src="{ __getEntityPhotoUrl( opts.item.photo_url ) }" />
        </div>
        <div class="cell auto">
            <p>{ opts.item.name }</p>
        </div>
    </div>

    <style>
        :scope {
            padding: 1em;
        }

        img {
            width: 72px;
            max-height: 72px;
        }

        p {
            padding-top: calc( 36px - 1em );
            text-align: left;
        }
    </style>
</entity-renderer>