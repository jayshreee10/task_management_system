"use client";
import React from "react";
import { toast, ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import usePusherChannel from "../hooks/usePusherChannel";

const ToastNotifications = ({ channelName, events }) => {
  usePusherChannel(
    channelName,
    events.map(({ event, callback }) => ({ event, callback }))
  );

  return (
    <ToastContainer
      position="top-right"
      autoClose={5000}
      hideProgressBar={false}
    />
  );
};

export default ToastNotifications;
