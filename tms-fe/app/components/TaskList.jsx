// "use client";

// function TaskList({ task }) {
//   return (
//     <div className="p-6 bg-white shadow-md rounded-lg">
//       <h2 className="text-2xl font-bold mb-4">{task.title}</h2>
//       <p className="text-sm text-gray-700 mb-2">
//         <strong>Description:</strong> {task.description}
//       </p>
//       <p className="text-sm text-gray-700 mb-2">
//         <strong>Due Date:</strong>{" "}
//         {task.due_date
//           ? new Date(task.due_date).toLocaleDateString()
//           : "N/A"}
//       </p>
//       <p className="text-sm text-gray-700 mb-2">
//         <strong>Priority:</strong> {task.priority}
//       </p>
//       <p className="text-sm text-gray-700 mb-2">
//         <strong>Status:</strong> {task.status}
//       </p>
//       <p className="text-sm text-gray-700 mb-2">
//         <strong>Created By:</strong> {task.created_by}
//       </p>
//       <p className="text-sm text-gray-700 mb-2">
//         <strong>Assigned To:</strong> {task.assigned_to}
//       </p>
//     </div>
//   );
// }

// export default TaskList;
