"use client";
import { useTaskContext } from "../context/TaskContextProvider";
import { useEffect } from "react";
import { useRouter } from "next/navigation"; 

export default function Table() {
  const { tasks, fetchTasks } = useTaskContext();
  const router = useRouter();

  useEffect(() => {
    fetchTasks();
  }, []);

  const handleRowClick = (task) => {
    router.push(`/pages/tasks/${task.id}`); 
  };

  return (
    <div className="p-6 my-8 space-y-8">
      <div className="overflow-hidden bg-white shadow-md rounded-lg">
        <table className="min-w-full table-auto">
          <thead>
            <tr className="bg-gray-500 text-white">
              <th className="px-4 py-2 text-sm font-semibold text-left">
                Task Title
              </th>
              <th className="px-4 py-2 text-sm font-semibold text-left">
                Description
              </th>
              <th className="px-4 py-2 text-sm font-semibold text-left">
                Due Date
              </th>
              <th className="px-4 py-2 text-sm font-semibold text-left">
                Priority
              </th>
              <th className="px-4 py-2 text-sm font-semibold text-left">
                Status
              </th>
            </tr>
          </thead>
          <tbody>
            {tasks.map((task, index) => (
              <tr
                key={task.id}
                className={`${
                  index % 2 === 0 ? "bg-white" : "bg-purple-100"
                } transition-colors cursor-pointer`}
                onClick={() => handleRowClick(task)}
              >
                <td className="px-4 py-3 text-sm font-medium text-gray-900">
                  {task.title}
                </td>
                <td className="px-4 py-3 text-sm text-gray-700">
                  {task.description}
                </td>
                <td className="px-4 py-3 text-sm text-gray-700">
                  {task.due_date
                    ? new Date(task.due_date).toLocaleDateString()
                    : "N/A"}
                </td>
                <td className="px-4 py-3 text-sm font-semibold text-center text-gray-500">
                  {task.priority}
                </td>
                <td className="px-4 py-3 text-sm font-semibold text-center text-gray-500">
                  {task.status}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}
