"use client";

import { useParams } from "next/navigation";
import { useEffect, useState } from "react";
import { useTaskContext } from "@/app/context/TaskContextProvider";
import Loader from "@/app/components/Loader";
import Pusher from "pusher-js";
import { toast, ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import ToastNotifications from "../../../components/ToastNotifications";

function TaskList() {
  const { taskId } = useParams();
  const [task, setTask] = useState(null);
  const [loading, setLoading] = useState(true);
  const { fetchTaskById } = useTaskContext();

  useEffect(() => {
    if (taskId) {
      setLoading(true);
      fetchTaskById(taskId)
        .then((data) => setTask(data))
        .finally(() => setTimeout(() => setLoading(false), 1000));
    }
  }, []);
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

    channel.bind("comment.added", (data) => {
      console.log("New Comment Added", data);
      toast.success("New Comment Added!");
    });

    return () => {
      pusher.unsubscribe(assignedTo);
    };
  }, []);
  if (loading) {
    return <Loader />;
  }

  if (!task) {
    return (
      <div className="text-center text-white mt-8">
        Task not found or failed to load.
      </div>
    );
  }

  return (
    <div className="p-8 bg-gray-900 text-white mx-auto max-w-full min-h-screen">
      <div className="bg-slate-400 shadow-lg text-white">
        <ToastContainer
          position="top-right"
          autoClose={5000}
          hideProgressBar={false}
        />
      </div>
      <div className="max-w-4xl mx-auto p-8 rounded-lg bg-transparent">
        <h2 className="text-4xl font-extrabold text-purple-400 mb-8 text-center">
          {task.title}
        </h2>

        <div className="space-y-6">
          <div className="flex flex-col md:flex-row justify-between items-start space-y-4 md:space-y-0">
            <p className="text-lg text-gray-300">
              <strong className="text-purple-400">Description:</strong>{" "}
              {task.description}
            </p>
            <p className="text-lg text-gray-300">
              <strong className="text-purple-400">Due Date:</strong>{" "}
              {task.due_date
                ? new Date(task.due_date).toLocaleDateString()
                : "N/A"}
            </p>
          </div>

          <div className="flex flex-col md:flex-row justify-between items-start space-y-4 md:space-y-0">
            <p className="text-lg text-gray-300">
              <strong className="text-purple-400">Priority:</strong>{" "}
              {task.priority}
            </p>
            <p className="text-lg text-gray-300">
              <strong className="text-purple-400">Status:</strong> {task.status}
            </p>
          </div>

          {/* <div className="flex flex-col md:flex-row justify-between items-start space-y-4 md:space-y-0">
            <p className="text-lg text-gray-300">
              <strong className="text-purple-400">Created By:</strong>{" "}
              {task.created_by}
            </p>
            <p className="text-lg text-gray-300">
              <strong className="text-purple-400">Assigned To:</strong>{" "}
              {task.assigned_to}
            </p>
          </div> */}
        </div>

        <div className="mt-12">
          <h3 className="text-2xl font-semibold text-purple-400 mb-6">
            Comments
          </h3>
          <div className="space-y-6 bg-slate-800 p-5 rounded-lg">
            {task.comments && task.comments.length > 0 ? (
              task.comments.map((comment, index) => (
                <div
                  key={index}
                  className="p-6 bg-gray-700 capitalize rounded-lg shadow-md w-full"
                >
                  <p className="text-lg text-gray-300">
                    <strong className="text-purple-400">
                      {comment.username}:
                    </strong>{" "}
                    {comment.comment}
                  </p>
                  <p className="text-sm text-gray-500">
                    {new Date(comment.timestamp).toLocaleString()}
                  </p>
                </div>
              ))
            ) : (
              <p className="text-lg text-gray-400">No comments yet.</p>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}

export default TaskList;
