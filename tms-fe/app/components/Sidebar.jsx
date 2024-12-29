"use client";

import { GiHamburgerMenu } from "react-icons/gi";
import { MdCancel } from "react-icons/md";
import Link from "next/link";

export default function Sidebar({ isOpen, toggleSidebar }) {
  return (
    <div className="flex">
      {/* Hamburger Icon to Toggle Sidebar */}
      <div
        className="p-4 text-white cursor-pointer lg:hidden"
        onClick={toggleSidebar}
      >
        <GiHamburgerMenu color="black" size={24} />
      </div>


      <div
        className={`fixed inset-0 z-50 bg-transparent bg-opacity-80 lg:static lg:bg-transparent transition-all duration-300 transform ${
          isOpen ? "translate-x-0" : "-translate-x-full"
        }`}
      >

        <div className="w-64 bg-gray-800 text-white h-full p-4">
        <MdCancel onClick={toggleSidebar}/>

          <h2 className="text-2xl font-semibold mb-6">Task Management</h2>
          <ul>
            <li className="mb-4">
              <Link href="/all-tasks" className="text-lg hover:text-blue-500">
                All Tasks
              </Link>
            </li>
            <li>
              <Link href="/team-tasks" className="text-lg hover:text-blue-500">
                Team Tasks
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  );
}
