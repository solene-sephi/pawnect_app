/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
    "./templates/**/*.{twig,html.twig}",
    "./assets/js/**/*.js",
    "./node_modules/flowbite/**/*.js",
    "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
  ],
  theme: {
    extend: {},
  },
  plugins: [require("flowbite/plugin")],
};
