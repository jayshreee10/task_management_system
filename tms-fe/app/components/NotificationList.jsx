import React, { useEffect } from "react";
import Pusher from "pusher-js";
import { toast, ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const NotificationList = () => {
  const user = localStorage.getItem("user");
  if (!user) {
    console.error("No user found in localStorage");
    return;
  }

  const parsedUser = JSON.parse(user);
  const assignedTo = parsedUser?.id.toString();

  useEffect(() => {
    const pusher = new Pusher("ad01d9f2e3e21cd28d10", {
      cluster: "ap2",
      encrypted: true,
    });

    const channel = pusher.subscribe(assignedTo);
    console.log(channel);
    channel.bind("task.created", (data) => {
      console.log("New Task Created:", data);
      toast.success("New Task Created!");
    });

    return () => {
      pusher.unsubscribe(assignedTo);
    };
  }, []);

  return (
    <div className="bg-slate-400 shadow-lg text-white">
      <ToastContainer
        position="top-right"
        autoClose={5000}
        hideProgressBar={false}
      />
    </div>
  );
};
export default NotificationList;
