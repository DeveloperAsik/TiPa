# 
#how to use
#

#-------------------
#TASK
#-------------------
# get all task
- http://localhost:8000/get-list/tasks?page=1&total=10&keyword=all

# get all task by keyword 
- http://localhost:8000/get-list/tasks?page=1&total=10&keyword=[id/title/task_section_id/task_section_name/task_type_id/task_type_name]&value=[int/string]
- http://localhost:8000/get-list/tasks?page=1&total=10&keyword=task_section_id&value=2

#get all task by keyword and order custom
- http://localhost:8000/get-list/tasks?page=1&total=10&keyword=all&order_key=[id/created_at]&order_value=[ASC, DESC]
- http://localhost:8000/get-list/tasks?page=1&total=10&keyword=all&order_key=created_at&order_value=ASC

# get task by id
- http://localhost:8000/get-list/tasks/1


#-------------------
#SECTION
#-------------------
# get all section
- http://localhost:8000/get-list/sections?page=1&total=10&keyword=all

# get all section by keyword 
- http://localhost:8000/get-list/sections?page=1&total=10&keyword=[id/title]&value=[int/string]
-http://localhost:8000/get-list/sections?page=1&total=10&keyword=id$value=1

# get section by id
- http://localhost:8000/get-list/sections/1