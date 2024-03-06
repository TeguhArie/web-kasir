/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ["./web/**/*.{html,php,js}"],
	theme: {
		extend: {
			width: {
				"8/15": "71%",
			},
		},
	},
	plugins: [],
};
