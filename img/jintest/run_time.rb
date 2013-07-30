#!/usr/bin/ruby -w

time1 = Time.now.to_f

puts "Current Time : " + time1.to_s

for i in 0..1000
   if i < 2 then
      next
   end
   puts "Value of local variable is #{i}"
end

# Time.now is a synonym:
time2 = Time.now.to_f
run_time = time2 - time1

puts "Current Time : " + time2.to_s
puts "Run Time: " + run_time.to_s