#!/usr/bin/ruby

# use backtick for space
msg = ARGV[0]

if msg == nil then
    puts "input:   a short message to encode in the intersection points of lines"
    puts "output:  some lines that go through multiple points"
    puts "human:   combine selections from this output with some simpler lines"
    puts "         of your choice to encode the message"
    puts "example: the lines y1 = x + 1 and y2 = 9 encode the message 'hi'"
    puts "         because they intersect at (8,9)"
    exit
end

# append trailing space if necessary
if (msg.length % 2) == 1 then msg += " " end
# convert spaces to backticks
msg = msg.gsub(" ", "`")

points = []

puts "msg = " + msg

def p_rat(r)
    s = r.to_s
    if s.end_with?("/1") then
        return s.gsub("/1", "").rjust(6)
    else
        return s.rjust(6)
    end
end

def p_rat_signed(r)
    s = p_rat(r)
    if s.match?("-") then
        return "-" + s.gsub("-", " ")
    else
        return "+" + s
    end
end

class Point
    attr_accessor :x, :y
    def initialize(x, y)
        @x = x
        @y = y
    end
    def to_s()
        "(" + @x.to_s + ", " + @y.to_s + ")"
    end
end

# construct Point objects
print "    = "
for i in 0..(msg.length-1)
    if i % 2 == 1 then next end
    c = msg[i].ord - 96
    d = msg[i+1].ord - 96
    print c.to_s + " " + d.to_s + " "
    p = Point.new(c, d)
    points[i/2] = p
    i = i+1
end
puts

# lines through individual points, with integer slopes and y-intercepts
for p in points
    # positive slope
    # negative slope
end

# lines through all pairs of points
points.each_with_index do |p, i|
    points.each_with_index do |q, j|
        if p == q then next end
        if i > j then next end 
        # slope
        rise = p.y - q.y
        run = p.x - q.x
        if run == 0 then
            puts "no run: " + p.to_s + " " + q.to_s
            next
        end
        slope = Rational(rise, run)
        # y-intercept
        b = -1 * (p.x * slope - p.y)
        # check
        y = q.x * slope + b 
        if y != q.y then
            puts "check failed:", y, q.y
            exit
        end
        # output
        print "y = " + p_rat(slope) + "x " + p_rat_signed(b) + "\t\t" + \
            (i+1).to_s + "_" + p.to_s.ljust(10) + " " + (j+1).to_s + "_" + q.to_s
        puts
    end
end



