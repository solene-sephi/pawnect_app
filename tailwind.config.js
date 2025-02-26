/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./templates/**/*.{twig,html.twig}",
    "./assets/js/**/*.js",
    "./node_modules/flowbite/**/*.js", // set up the path to the flowbite package
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require("flowbite/plugin"), // add the flowbite plugin
  ],
};
