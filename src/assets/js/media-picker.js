/**
 * Media Picker
 *
 * @author Takuto Yanagida
 * @version 2023-06-06
 */

function wpinc_meta_media_picker_initialize(key) {
	const NS        = 'wpinc-meta-media-picker';
	const CLS_SEL   = NS + '-select';
	const CLS_DEL   = NS + '-delete';
	const ID_BODY   = key + '-body';
	const IDN_SRC   = key + '_src';
	const IDM_TITLE = key + '_title';

	init(document.getElementById(ID_BODY));

	function init(body) {
		const sel = body.getElementsByClassName(CLS_SEL)[0];
		window.wpinc.meta.setMediaPicker(sel, null, set_item, {
			multiple      : false,
			type          : '',
			parentGen     : -1,
			title         : sel.innerText,
			media_id_input: key
		});

		const del = body.getElementsByClassName(CLS_DEL)[0];
		del.addEventListener('click', () => {
			set_item(null, { id: '', url: '', title: '' });
		});
	}

	function set_item(dummy, f) {
		document.getElementById(key).value = f.id;
		document.getElementById(IDN_SRC).style.backgroundImage = f.url ? (`url("${f.url}")`) : '';
		document.getElementById(IDM_TITLE).value = f.title;
	}
}
