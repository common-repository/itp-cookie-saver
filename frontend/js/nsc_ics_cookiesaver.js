(function() {
  window.addEventListener("beforeunload", function(event) {
    navigator.sendBeacon(document.location.origin);
  });
})();
