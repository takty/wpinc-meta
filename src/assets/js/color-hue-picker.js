/**
 * Color Hue Picker
 *
 * @author Takuto Yanagida
 * @version 2023-06-29
 */

function wpinc_meta_color_hue_picker_initialize(key) {
	const NS          = 'wpinc-meta-color-hue-picker';
	const ID_BODY     = key + '-body';
	const CLS_SAMPLE  = NS + '-sample';
	const CLS_DEFAULT = NS + '-default';
	const CLS_L       = NS + '-l';
	const CLS_C       = NS + '-c';
	const CLS_H       = NS + '-h';

	const body = document.getElementById(ID_BODY);
	const data = document.getElementById(key);

	const s = body.getElementsByClassName(CLS_SAMPLE)[0];
	const d = body.getElementsByClassName(CLS_DEFAULT)[0];

	const l = body.getElementsByClassName(CLS_L)[0];
	const c = body.getElementsByClassName(CLS_C)[0];
	const h = body.getElementsByClassName(CLS_H)[0];

	setHexColor(data.value);

	d.addEventListener('click', () => {
		setHexColor(data.dataset.defaultColor);
	});

	h.addEventListener('change', () => {
		const nc  = [parseInt(l.value, 10), parseInt(c.value, 10), parseInt(h.value, 10)];
		const rgb = RGB.fromLab(Lab.toOrthogonalCoordinate(nc));

		const hex = rgbToHex(rgb);
		data.value              = hex;
		s.style.backgroundColor = hex;
		s.title                 = hex;
	});

	function setHexColor(hex) {
		s.style.backgroundColor = hex;
		s.title                 = hex;

		const rgb = hexToRgb(hex);
		const lch = Lab.toPolarCoordinate(RGB.toLab(rgb));

		l.value = lch[0];
		c.value = lch[1];
		h.value = lch[2];
	}

	function hexToRgb(hex) {
		const s = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		hex = hex.replace(s, (m, r, g, b) => (r + r + g + g + b + b));
		const c = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return c ? [parseInt(c[1], 16), parseInt(c[2], 16), parseInt(c[3], 16)] : [0, 0, 0];
	}

	function rgbToHex([r, g, b]) {
		return '#' + (1 << 24 | r << 16 | g << 8 | b).toString(16).slice(1);
	}
}
