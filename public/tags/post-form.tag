<post-form>
    <form ref="form" class="card" onsubmit={ submit }>
        <div class="card-section">
            <textarea ref="text_content" name="description" class="text-content"></textarea>
            <div class="toolbar">
                <button class="button" type="button" name="photo_button"><i class="fa fa-image"></i></button>
                <button class="button" type="button" name="video_button"><i class="fa fa-video"></i></button>
                <button ref="visibility_button" class="button" type="button" data-toggle="post-visiblity-selector"><i class="fa fa-globe" ref="visibility_icon"></i>
                </button>
                <button class="button float-right" type="submit"><i class="fa fa-send"></i></button>
                <div ref="visibility_dropdown" class="dropdown-pane visibility-dropdown" id="post-visiblity-selector" data-dropdown
                     data-auto-focus="true">
                    <label>
                        <input type="radio" class="visilibity-selector" name="visibility" value="PUBLIC" checked onchange={ visibilityClicked } />
                        <span class="visibility-label">
                            <i class="fa fa-globe"></i> Public
                        </span>
                    </label>
                    <label>
                        <input type="radio" class="visilibity-selector" name="visibility" value="NETWORKMEMBERS" onchange={ visibilityClicked } />
                        <span class="visibility-label">
                            <i class="fa fa-suitcase"></i> Membres du réseau
                        </span>
                    </label>
                    <label>
                        <input type="radio" class="visilibity-selector" name="visibility" value="FRIENDS" onchange={ visibilityClicked } />
                        <span class="visibility-label">
                            <i class="fa fa-users"></i> Amis
                        </span>
                    </label>
                    <label>
                        <input type="radio" class="visilibity-selector" name="visibility" value="RESTRICTED" onchange={ visibilityClicked } />
                        <span class="visibility-label">
                            <i class="fa fa-user"></i> Restreint
                        </span>
                    </label>
                </div>
            </div>
        </div>
    </form>

    <style>
        :scope {
            display: block;
        }

        .card-section {
            padding: 0;
        }

        .text-content {
            border: 0;
            border-bottom: 1px solid #e6e6e6;
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

        .visibility-dropdown {
            padding: 0;
        }

        .visilibity-selector {
            display: none;
        }

        .visibility-label {
            display: block;
            width: 100%;
            padding: 1em;
            background: white;
            cursor: pointer;
        }

        .visilibity-selector:checked + .visibility-label {
            background: #23a3ba;
            color: white;
        }
    </style>

    <script>
	    this.form = {
		    "photo_ids" : [],
		    "video_ids": [],
		    "post_visibility_user_ids": []
	    };

        clearForm() {
	        this.form = {
		        "photo_ids" : [],
		        "video_ids": [],
		        "post_visibility_user_ids": []
	        };
        }

        this.icons = {
        	"PUBLIC": "fa fa-globe",
	        "NETWORKMEMBERS": "fa fa-suitcase",
	        "FRIENDS": "fa fa-users",
	        "RESTRICTED": "fa fa-user"
        };

        let that = this;
        function mount() {
	        $( that.refs.visibility_button ).foundation();
	        $( that.refs.visibility_dropdown ).foundation();
        }

        visibilityClicked( e ) {
            that.refs.visibility_icon.className = that.icons[ e.target.value ];
	        $( that.refs.visibility_dropdown ).foundation( 'close' );
            if( e.target.value === "RESTRICTED" ) {
	            openFriendSelector();
            }
        }

        function onFriendSelected( friends ) {
        	that.form.post_visibility_user_ids = [];
			for( let i = 0; i < friends.length; i++ ) {
				that.form.post_visibility_user_ids.push( friends[ i ].user_id );
			}
        }

        function onFriendNotSelected() {
        	that.clearVisibility();
        }

        function openFriendSelector() {
			$( that.refs.form ).append( $( '<friend-selector></friend-selector>' ) );
			window.riot.mount( 'friend-selector', { onSelected: onFriendSelected, onCancelled: onFriendNotSelected, baseApiPath: opts.baseApiPath, postId: opts.postId } );
        }

        this.on('mount', function(){
	        mount();
        });

        function getForm() {
            that.form[ "description" ] = that.refs.text_content.value;
            let visibilityRadios = that.refs.form.querySelectorAll( 'input[name="visibility"]' );
            for( let i = 0; i < visibilityRadios.length; i++ ) {
            	if( visibilityRadios[ i ].checked ) {
		            that.form[ "visibility" ] = visibilityRadios[ i ].value;
            	}
            }
            return that.form;
        }

        clearVisibility() {
	        let checkbox = $( that.refs.form.querySelector( 'input[name="visibility"]' ) );
	        checkbox.prop( 'checked', true );
	        that.refs.visibility_icon.className = that.icons[ checkbox[ 0 ].value ];
	        $( that.refs.visibility_dropdown ).foundation( 'close' );
        }

        clear() {
		    that.clearForm();
            that.clearVisibility();
            that.refs.text_content.value = "";
        }

        disable() {
            let elems = that.refs.form.querySelectorAll( 'button' );
            for( let i = 0; i < elems.length; i++ ) {
            	elems[ i ].disabled = true;
            }
            that.refs.text_content.disabled = true;
        }

        enable() {
	        let elems = that.refs.form.querySelectorAll( 'button' );
	        for( let i = 0; i < elems.length; i++ ) {
		        elems[ i ].disabled = false;
	        }
	        that.refs.text_content.disabled = false;
        }

        submit( e ) {
        	e.preventDefault();
        	e.stopImmediatePropagation();
        	that.disable();
            opts.callback(getForm());
        }
    </script>
</post-form>