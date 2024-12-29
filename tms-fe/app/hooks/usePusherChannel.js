// "use client";
// import { useEffect } from "react";
// import Pusher from "pusher-js";

// const usePusherChannel = (channelName, events) => {
//   useEffect(() => {
//     if (!channelName || !events) return;

//     const pusher = new Pusher("ad01d9f2e3e21cd28d10", {
//       cluster: "ap2",
//       encrypted: true,
//     });

//     const channel = pusher.subscribe(channelName);

//     // Bind each event to its corresponding callback
//     events.forEach(({ event, callback }) => {
//       channel.bind(event, callback);
//     });

//     return () => {
//       events.forEach(({ event }) => {
//         channel.unbind(event);
//       });
//       pusher.unsubscribe(channelName);
//     };
//   }, [channelName, events]);
// };

// export default usePusherChannel;
