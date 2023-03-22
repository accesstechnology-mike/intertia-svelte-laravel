const colors = require("tailwindcss/colors");

module.exports = {
  darkMode: "class",
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.svelte",
    "./resources/**/*.js",
	require('path').join(require.resolve(
		'@skeletonlabs/skeleton'),
		'../**/*.{html,js,svelte,ts}'
	)
  ],
  theme: {
    extend: {},
  },
  plugins: [
	...require('@skeletonlabs/skeleton/tailwind/skeleton.cjs')()
  ],
};
