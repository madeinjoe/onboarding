const configuration = {
  sass: ["./assets/src/scss/style.scss"],
  js: ["./assets/src/js/script.js"],
  browserSync: {
    proxy: "http://wordpress.local/",
    host: "wordpress.local",
    watchTask: true,
    open: "external",
    files: [
      "./assets/dist/css/*.min.css",
      "./assets/dist/js/*.min.js",
      "./**/*.php",
    ],
    logLevel: "silent",
  },
};

// eslint-disable-next-line no-undef
module.exports = configuration;
