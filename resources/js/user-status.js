import Echo from "laravel-echo";

window.Echo = new Echo({
    broadcaster: "pusher",
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});

if (window.Laravel.userId) {
    Echo.private(`user.${window.Laravel.userId}`).listen(
        "UserStatusChanged",
        (event) => {
            // Handle user status change event
            console.log("User status changed:", event);
        }
    );

    // Add logic to detect when the user leaves or returns to the website
    document.addEventListener("visibilitychange", () => {
        if (document.visibilityState === "visible") {
            // User returned to the website
            Echo.private(`user.${window.Laravel.userId}`).whisper(
                "user.active",
                true
            );
        } else {
            // User left the website
            Echo.private(`user.${window.Laravel.userId}`).whisper(
                "user.active",
                false
            );
        }
    });
}
