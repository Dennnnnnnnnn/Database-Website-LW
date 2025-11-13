This database is designed to manage workflow of a gym website. It includes such classes:
members, staff, training sessions and their attendance, payments, workout, diet plans, equipment
maintenance, and communication via notifications and complaints. Member will be able to book a visit
to the gym via site
Tables:
1. Members – table that stores information about members (Attributes: name, surname, date of
birth, gender, phone number, email, address, height, weight)
2. Staff – table that stores information about workers in the gym (Attributes: name, surname,
date of birth, experience, role(trainer, manager, assistant etc.), email, phone number,
shifts(morning, afternoon, evening)
3. Complains – stores members‘ complains about work of the gym in general and staff
(Attributes: complain type, description, status, date)
4. Diet plans – stores members‘ diet plans (Attributes: plan name, calories per day, protein(in
grams), carbs(in grams), fats(in grams), water intake, start date, end date)
5. Equipment – stores necessary information about equipment in the gym (Attributes: category,
condition, maintenance date, warranty)
6. Notifications – messages sent by gym to its members - usually news and reminders to buy a
new subscription (Attributes: notification type, message, sent date, is responce required or
not)
7. Personal training sessions – stores information about training sessions (Attributes: date,
duration, calories burned, feedback)
8. Attendance – controls members‘ attendance to the gym at specified date (Attributes: date,
attended)
9. Payments – controls member‘s paymemts about members’ services (Attributes: amount,
payment date, payment method, payment status, discount)
10. Workout plans – controls members‘ workout plans (Attributes: workout name, duration, plan
start date, plan end date)
Relationships between tables:
 Members follow specific diet plans.
 Members attend personal training sessions, which are conducted by staff.
 Payments are made by members for personal training sessions.
 Workout plans are assigned to members and created by staff.
 Staff maintain equipment.
 Notifications are sent to members.
 Members submit complaints.
